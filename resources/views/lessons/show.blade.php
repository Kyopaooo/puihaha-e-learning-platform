@extends('layouts.app')

@section('title', $lesson->title)
@section('heading', $course->title)

@section('content')
<div class="panel lesson-content">
    <a href="{{ route('courses.show', $course) }}" class="text-link">← Back to course</a>

    @php $canManage = auth()->user()->role === 'admin' || (auth()->user()->role === 'instructor' && $course->instructor_id === auth()->id()); @endphp

    @if($canManage)
        <div class="d-flex gap-2 justify-content-end mb-3">
            <a href="{{ route('lessons.edit', [$course, $lesson]) }}" class="btn-outline">Edit lesson</a>
            <form method="POST" action="{{ route('lessons.destroy', [$course, $lesson]) }}"
                  onsubmit="return confirm('Delete this lesson? Its completion records will also be removed.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-outline">Delete lesson</button>
            </form>
        </div>

        <form method="POST" action="{{ route('materials.store', [$course, $lesson]) }}" enctype="multipart/form-data" class="stack-form mb-4">
            @csrf
            <span class="eyebrow">LEARNING MATERIALS</span>
            <label>Material title</label><input name="title" required>
            <label>Select file (PDF, DOC, DOCX, PPT, PPTX, TXT, image, MP4; max 20 MB)</label>
            <input type="file" name="file" required accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.jpg,.jpeg,.png,.mp4">
            <button type="submit" class="btn-outline">Upload material</button>
        </form>
    @endif

    @if($lesson->materials->isNotEmpty())
        <div class="panel mb-3">
            <span class="eyebrow">DOWNLOADABLE MATERIALS</span>
            @foreach($lesson->materials as $material)
                <div class="lesson-row">
                    <strong>{{ $material->title }}</strong>
                    <small>{{ $material->original_name }}</small>
                    <a class="text-link ms-auto" href="{{ route('materials.download', [$course, $lesson, $material]) }}">Download</a>
                </div>
            @endforeach
        </div>
    @endif

    <span class="eyebrow mt-4">LESSON</span>
    <h2 class="serif-title">{{ $lesson->title }}</h2>

    @if($lesson->video_url)
        <div class="video-link"><a href="{{ $lesson->video_url }}" target="_blank" rel="noopener">Open lesson video ↗</a></div>
    @endif

    <div class="lesson-copy">{!! nl2br(e($lesson->content)) !!}</div>

    @if(auth()->user()->role === 'student')
        <form method="POST" action="{{ route('lessons.complete', [$course, $lesson]) }}">@csrf
            <button class="btn-primary">Mark lesson complete ✓</button>
        </form>
    @endif
</div>
@endsection
