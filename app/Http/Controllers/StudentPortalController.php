<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentPortalController extends Controller
{
    public function membership()
    {
        abort_unless(auth()->user()->role === 'student', 403);

        $member = auth()->user()->member;

        if ($member) {
            $member->load([
                'membershipCategory',
                'membershipLevel',
                'transactions.level',
                'transactions.payments',
            ]);
        }

        return view('student.membership', compact('member'));
    }
}
