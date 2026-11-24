@extends('layouts.app')

@section('title', 'Edit lesson')
@section('heading', 'Edit lesson')

@section('content')
<div class="panel form-panel">
    <p class="muted">Course: {{ $course->title }}</p>

    <form method="POST" action="{{ route('lessons.update', [$course, $lesson]) }}">
        @csrf
        @method('PUT')

        <div class="stack-form">
            <label>Lesson title</label>
            <input name="title" value="{{ old('title', $lesson->title) }}" required>

            <label>Lesson content</label>
            <textarea name="content" rows="8">{{ old('content', $lesson->content) }}</textarea>

            <label>Video URL (optional)</label>
            <input type="url" name="video_url" value="{{ old('video_url', $lesson->video_url) }}">

            <label>Display order</label>
            <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $lesson->sort_order) }}">

            <label class="check-row">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $lesson->is_published))>
                Publish lesson
            </label>

            <div class="form-actions">
                <a href="{{ route('lessons.show', [$course, $lesson]) }}" class="btn-outline">Cancel</a>
                <button type="submit" class="btn-primary">Save lesson</button>
            </div>
        </div>
    </form>
</div>
@endsection
