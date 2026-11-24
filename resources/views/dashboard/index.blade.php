@extends('layouts.app')
@section('title','Overview')
@section('heading','A good day to learn.')
@section('content')
<div class="welcome-banner">
    <div>
        <span class="eyebrow">YOUR LEARNING SPACE</span>
        <h2>Welcome back, {{ Str::before($user->name,' ') }}.</h2>
        <p>Make today a small step toward something extraordinary.</p>
    </div>
    <a href="{{ route('courses.index') }}" class="btn-lightline">Explore courses <span>→</span></a>
</div>

@if($user->role === 'admin')
    <div class="stats-grid">
        <div class="stat-card"><span>Registered members</span><strong>{{ number_format($memberCount) }}</strong><small>All membership records</small></div>
        <div class="stat-card"><span>Active members</span><strong>{{ number_format($activeMembers) }}</strong><small>Currently active</small></div>
        <div class="stat-card"><span>Pending transactions</span><strong>{{ number_format($pendingTransactions) }}</strong><small>Awaiting payment or review</small></div>
        <div class="stat-card"><span>Payments collected</span><strong>₱{{ number_format($collectedPayments,2) }}</strong><small>Recorded payments</small></div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <div><span class="eyebrow">LATEST ACTIVITY</span><h3>Recent transactions</h3></div>
            <a href="{{ route('transactions.index') }}" class="text-link">View all →</a>
        </div>
        <div class="table-responsive">
            <table class="table elegant-table">
                <thead><tr><th>Reference</th><th>Member</th><th>Amount</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($recentTransactions as $tx)
                    <tr>
                        <td><a href="{{ route('transactions.show',$tx) }}">{{ $tx->reference_number }}</a></td>
                        <td>{{ $tx->member->full_name }}</td>
                        <td>₱{{ number_format($tx->amount,2) }}</td>
                        <td><span class="status status-{{ strtolower($tx->status) }}">{{ $tx->status }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty-state">No transactions recorded yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@elseif($user->role === 'instructor')
    <div class="stats-grid">
        <div class="stat-card"><span>My courses</span><strong>{{ $user->taughtCourses()->count() }}</strong><small>Courses created by you</small></div>
        <div class="stat-card"><span>Enrolled students</span><strong>{{ \App\Models\Enrollment::whereIn('course_id', $user->taughtCourses()->select('id'))->count() }}</strong><small>Across your courses</small></div>
    </div>
    <div class="panel">
        <div class="panel-head">
            <div><span class="eyebrow">TEACHING WORKSPACE</span><h3>Your courses</h3></div>
            <a href="{{ route('courses.manage') }}" class="text-link">Manage courses →</a>
        </div>
        @forelse($user->taughtCourses as $course)
            <div class="lesson-row">
                <div><strong>{{ $course->title }}</strong><small>{{ ucfirst($course->status) }}</small></div>
                <a class="text-link" href="{{ route('courses.enrollments',$course) }}">View students →</a>
            </div>
        @empty
            <p class="empty-state">You have not created a course yet.</p>
        @endforelse
    </div>

@else
    <div class="stats-grid student-stats-grid">
        <div class="stat-card"><span>Published courses</span><strong>{{ $courseCount }}</strong><small>Available to explore</small></div>
        <div class="stat-card"><span>Students</span><strong>{{ $studentCount }}</strong><small>Learning community</small></div>
        <div class="stat-card membership-summary-card">
            <span>My membership</span>
            <strong>{{ $user->member?->membershipLevel?->name ?? 'Not set' }}</strong>
            <small>{{ $user->member?->status ?? 'Contact an administrator' }}</small>
            <a class="membership-action" href="{{ route('student.membership') }}">
                View membership &amp; payments <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <div><span class="eyebrow">CONTINUE LEARNING</span><h3>Your courses</h3></div>
            <a href="{{ route('courses.index') }}" class="text-link">Browse library →</a>
        </div>
        <div class="course-grid">
            @forelse($myEnrollments as $enrollment)
                @php
                    $total = $enrollment->course->lessons->where('is_published', true)->count();
                    $done = $enrollment->progress->whereNotNull('completed_at')->count();
                    $percent = $total > 0 ? (int) round($done / $total * 100) : 0;
                @endphp
                <a class="course-card" href="{{ route('courses.show',$enrollment->course) }}">
                    <div class="course-art">P<span>LEARN</span></div>
                    <div class="course-info">
                        <small>{{ $enrollment->course->category?->name ?? 'COURSE' }}</small>
                        <h4>{{ $enrollment->course->title }}</h4>
                        <p>{{ $done }}/{{ $total }} lessons · {{ $percent }}% complete</p>
                        <div class="progress" style="height:7px"><div class="progress-bar" style="width:{{ $percent }}%"></div></div>
                    </div>
                </a>
            @empty
                <p class="empty-state">You haven't enrolled in a course yet. Explore the course library to begin.</p>
            @endforelse
        </div>
    </div>
@endif

<div class="dashboard-info-grid">
    @include('dashboard.partials.weather')
    @include('dashboard.partials.location-map')
</div>
@endsection
