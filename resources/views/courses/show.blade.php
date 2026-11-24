@extends('layouts.app')

@section('title', $course->title)
@section('heading', 'Course overview')

@section('content')
<div class="course-hero">
    <span class="eyebrow">{{ $course->category?->name ?? 'PUHAHA COURSE' }}</span>
    <h2>{{ $course->title }}</h2>
    <p>{{ $course->description }}</p>
    <small>Created by {{ $course->instructor->name }}</small>

    <div class="mt-3">
        @if(auth()->user()->role === 'student' && ! $enrolled)
            <form method="POST" action="{{ route('courses.enroll', $course) }}">@csrf
                <button class="btn-primary">Enroll in this course →</button>
            </form>
        @elseif($enrolled)
            <span class="status status-approved">You're enrolled</span>
            <div class="mt-2"><strong>Your progress: {{ $progressPercent }}%</strong></div>
            <div class="progress mt-1" style="height:8px;max-width:360px">
                <div class="progress-bar" style="width:{{ $progressPercent }}%"></div>
            </div>
            <small>{{ $completedCount }} of {{ $publishedLessonCount }} published lessons completed</small>
        @elseif(in_array(auth()->user()->role, ['admin', 'instructor']) &&
            ($course->instructor_id === auth()->id() || auth()->user()->role === 'admin'))
            <a href="{{ route('courses.edit', $course) }}" class="btn-outline">Edit course</a>
            <a href="{{ route('courses.enrollments', $course) }}" class="btn-outline ms-2">View enrolled students</a>
        @endif
    </div>
</div>

<div class="panel mt-4">
    <div class="panel-head">
        <div><span class="eyebrow">COURSE CONTENT</span><h3>Lessons</h3></div>
        <span class="muted">{{ $course->lessons->count() }} lessons</span>
    </div>

    @foreach($course->lessons as $lesson)
        @php $canManage = auth()->user()->role === 'admin' || (auth()->user()->role === 'instructor' && $course->instructor_id === auth()->id()); @endphp
        @if($lesson->is_published || $canManage)
            <div class="lesson-row">
                <div class="lesson-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                <div>
                    <strong>{{ $lesson->title }}</strong>
                    <small>{{ $lesson->is_published ? 'Available' : 'Draft' }}</small>
                </div>
                @if($enrolled || $canManage)
                    <a class="text-link ms-auto" href="{{ route('lessons.show', [$course, $lesson]) }}">Open →</a>
                @endif
                @if($enrolled && in_array($lesson->id, $completedLessonIds))
                    <span class="status status-approved ms-2">Completed</span>
                @endif
                @if($canManage)
                    <a class="text-link ms-2" href="{{ route('lessons.edit', [$course, $lesson]) }}">Edit</a>
                @endif
            </div>
        @endif
    @endforeach

    @if(auth()->user()->role === 'admin' || (auth()->user()->role === 'instructor' && $course->instructor_id === auth()->id()))
        <hr>
        <form method="POST" action="{{ route('lessons.store', $course) }}" class="stack-form">
            @csrf
            <span class="eyebrow">ADD A LESSON</span>
            <label>Lesson title</label><input name="title" required>
            <label>Lesson content</label><textarea name="content" rows="4"></textarea>
            <label>Video URL (optional)</label><input type="url" name="video_url">
            <label>Display order</label><input type="number" name="sort_order" min="0" value="0">
            <label class="check-row"><input type="checkbox" name="is_published" value="1"> Publish immediately</label>
            <button class="btn-primary">Add lesson</button>
        </form>
    @endif
</div>
@endsection
