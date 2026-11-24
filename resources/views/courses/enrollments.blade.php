@extends('layouts.app')

@section('title', 'Course enrollments')
@section('heading', 'Course enrollments')

@section('content')
<div class="page-toolbar">
    <div>
        <span class="eyebrow">STUDENT MONITORING</span>
        <p class="muted mb-0">{{ $course->title }}</p>
    </div>
    <a href="{{ route('courses.show', $course) }}" class="btn-outline">Back to course</a>
</div>

<div class="panel">
    <div class="panel-head">
        <div>
            <span class="eyebrow">ENROLLED STUDENTS</span>
            <h3>{{ $enrollments->total() }} student(s)</h3>
        </div>
        <span class="muted">{{ $totalLessons }} published lessons</span>
    </div>

    <div class="table-responsive">
        <table class="table elegant-table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Email</th>
                    <th>Enrolled</th>
                    <th>Lessons completed</th>
                    <th>Progress</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrollments as $enrollment)
                    @php
                        $completed = $enrollment->progress
                            ->whereNotNull('completed_at')
                            ->whereIn('lesson_id', $publishedLessonIds)
                            ->count();
                        $percent = $totalLessons > 0 ? (int) round($completed / $totalLessons * 100) : 0;
                    @endphp
                    <tr>
                        <td><strong>{{ $enrollment->student->name }}</strong></td>
                        <td>{{ $enrollment->student->email }}</td>
                        <td>{{ $enrollment->enrolled_at?->format('M d, Y') ?? '—' }}</td>
                        <td>{{ $completed }} / {{ $totalLessons }}</td>
                        <td>
                            <div>{{ $percent }}%</div>
                            <div class="progress" style="height:7px; min-width:90px">
                                <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td>{{ ucfirst($enrollment->status) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty-state">No students have enrolled in this course yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $enrollments->links() }}</div>
</div>
@endsection
