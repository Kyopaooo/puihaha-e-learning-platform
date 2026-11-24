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
            <form method="POST" action="{{ route('courses.enroll', $course) }}">
                @csrf
                <button class="btn-primary">Enroll in this course →</button>
            </form>
        @elseif($enrolled)
            <span class="status status-approved">You're enrolled</span>
        @elseif(in_array(auth()->user()->role, ['admin', 'instructor']) &&
            ($course->instructor_id === auth()->id() || auth()->user()->role === 'admin'))
            <a href="{{ route('courses.edit', $course) }}" class="btn-outline">Edit course</a>
        @endif
    </div>
</div>

<div class="panel mt-4">
    <div class="panel-head">
        <div>
            <span class="eyebrow">COURSE CONTENT</span>
            <h3>Lessons</h3>
        </div>
        <span class="muted">{{ $course->lessons->count() }} lessons</span>
    </div>

    @foreach($course->lessons as $lesson)
        <div class="lesson-row">
            <div class="lesson-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
            <div>
                <strong>{{ $lesson->title }}</strong>
                <small>{{ $lesson->is_published ? 'Available' : 'Draft' }}</small>
            </div>

            @if(auth()->user()->role !== 'student' || $enrolled)
                <a class="text-link ms-auto" href="{{ route('lessons.show', [$course, $lesson]) }}">Open →</a>
            @endif

            @if(in_array(auth()->user()->role, ['admin', 'instructor']) &&
                ($course->instructor_id === auth()->id() || auth()->user()->role === 'admin'))
                <a class="text-link ms-2" href="{{ route('lessons.edit', [$course, $lesson]) }}">Edit</a>
            @endif
        </div>
    @endforeach

    @if(in_array(auth()->user()->role, ['admin', 'instructor']) &&
        ($course->instructor_id === auth()->id() || auth()->user()->role === 'admin'))
        <hr>
        <form method="POST" action="{{ route('lessons.store', $course) }}" class="stack-form">
            @csrf
            <span class="eyebrow">ADD A LESSON</span>
            <label>Lesson title</label>
            <input name="title" required>

            <label>Lesson content</label>
            <textarea name="content" rows="4"></textarea>

            <label>Video URL (optional)</label>
            <input type="url" name="video_url">

            <label>Display order</label>
            <input type="number" name="sort_order" min="0" value="0">

            <label class="check-row">
                <input type="checkbox" name="is_published" value="1">
                Publish immediately
            </label>

            <button class="btn-primary">Add lesson</button>
        </form>
    @endif
</div>
@endsection
