<?php

namespace App\Http\Controllers;

use App\Models\{
    Member, MembershipTransaction, Payment, Course, User, Enrollment, LearningCenter
};
use Illuminate\Support\Facades\{Cache, Http};

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $weather = null;

        $center = LearningCenter::where('is_active', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->first();

        if ($center) {
            $cacheKey = 'puihaha_weather_'.$center->id;
            $weather = Cache::remember($cacheKey, now()->addMinutes(15), function () use ($center) {
                try {
                    $response = Http::timeout(8)->get('https://api.open-meteo.com/v1/forecast', [
                        'latitude' => $center->latitude,
                        'longitude' => $center->longitude,
                        'current' => 'temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m',
                        'timezone' => 'auto',
                    ]);

                    return $response->successful() ? $response->json() : null;
                } catch (\Throwable $exception) {
                    report($exception);
                    return null;
                }
            });
        }

        return view('dashboard.index', [
            'user' => $user,
            'memberCount' => Member::count(),
            'activeMembers' => Member::where('status', 'Active')->count(),
            'pendingTransactions' => MembershipTransaction::where('status', 'Pending')->count(),
            'collectedPayments' => Payment::sum('amount'),
            'courseCount' => Course::where('status', 'published')->count(),
            'studentCount' => User::where('role', 'student')->count(),
            'recentTransactions' => MembershipTransaction::with('member')->latest()->take(6)->get(),
            'myEnrollments' => $user->role === 'student'
                ? Enrollment::with('course.lessons')->where('student_id', $user->id)->latest()->take(4)->get()
                : collect(),
            'center' => $center,
            'weather' => $weather,
        ]);
    }
}
