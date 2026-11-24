<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'The provided credentials do not match our records.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        if (! Auth::user()->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors(['email' => 'This account is inactive.']);
        }

        if (! Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->intended(route('dashboard'));
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Create the login and its membership profile together so they cannot become disconnected.
        $user = DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'student',
                'is_active' => true,
            ]);

            $nameParts = preg_split('/\s+/', trim($data['name']), -1, PREG_SPLIT_NO_EMPTY);
            $firstName = array_shift($nameParts) ?: 'Student';
            $lastName = implode(' ', $nameParts);

            if ($lastName === '') {
                $lastName = 'Student';
            }

            $studentCategory = MembershipCategory::where('name', 'Student')->first();

            do {
                $memberCode = 'PUH-' . now()->format('ymd') . '-' . Str::upper(Str::random(5));
            } while (Member::where('member_code', $memberCode)->exists());

            Member::create([
                'user_id' => $user->id,
                'member_code' => $memberCode,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $user->email,
                'category' => 'Student',
                'level' => 'Not assigned',
                'status' => 'Active',
                'joined_at' => now()->toDateString(),
                'membership_category_id' => $studentCategory?->id,
                'membership_level_id' => null,
                'expires_at' => null,
            ]);

            return $user;
        });

        // Send verification only after the database transaction has committed.
        event(new Registered($user));

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('verification.notice')
            ->with('success', 'Account and membership profile created. Check your email to verify your account.');
    }

    public function verificationNotice()
    {
        return view('auth.verify-email');
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('dashboard')
            ->with('success', 'Your email address has been verified.');
    }

    public function resendVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'A new verification link has been sent to your email address.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
