@extends('layouts.app')

@section('title', $lesson->title)
@section('heading', $course->title)

@section('content')
<div class="panel lesson-content">
    <a href="{{ route('courses.show', $course) }}" class="text-link">← Back to course</a>

    @if(in_array(auth()->user()->role, ['admin', 'instructor']))
        <div class="d-flex gap-2 justify-content-end mb-3">
            <a href="{{ route('lessons.edit', [$course, $lesson]) }}" class="btn-outline">Edit lesson</a>
            <form method="POST"
                  action="{{ route('lessons.destroy', [$course, $lesson]) }}"
                  onsubmit="return confirm('Delete this lesson? This will also remove its completion records.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-outline">Delete lesson</button>
            </form>
        </div>
    @endif

    <span class="eyebrow mt-4">LESSON</span>
    <h2 class="serif-title">{{ $lesson->title }}</h2>

    @if($lesson->video_url)
        <div class="video-link">
            <a href="{{ $lesson->video_url }}" target="_blank" rel="noopener">Open lesson video ↗</a>
        </div>
    @endif

    <div class="lesson-copy">{!! nl2br(e($lesson->content)) !!}</div>

    @if(auth()->user()->role === 'student')
        <form method="POST" action="{{ route('lessons.complete', [$course, $lesson]) }}">
            @csrf
            <button class="btn-primary">Mark lesson complete ✓</button>
        </form>
    @endif
</div>
@endsection
