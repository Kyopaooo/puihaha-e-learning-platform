@extends('layouts.app')

@section('title', 'Manage courses')
@section('heading', 'Course management')

@section('content')
    <div class="page-toolbar">
        <p class="muted">Create and maintain your learning content.</p>
        <a href="{{ route('courses.create') }}" class="btn-primary">+ Create course</a>
    </div>

    <div class="panel">
        <div class="table-responsive">
            <table class="table elegant-table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td><strong>{{ $course->title }}</strong></td>
                            <td>{{ $course->category?->name ?? '—' }}</td>
                            <td>{{ ucfirst($course->status) }}</td>
                            <td class="text-end">
                                <a class="text-link" href="{{ route('courses.show', $course) }}">Open →</a>
                                <a class="text-link ms-2" href="{{ route('courses.edit', $course) }}">Edit</a>

                                <form method="POST"
                                      action="{{ route('courses.destroy', $course) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Permanently delete &quot;{{ addslashes($course->title) }}&quot;? Its lessons, uploaded learning materials, enrollments, and student progress will also be deleted. This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn-outline ms-2"
                                            style="color:#a33;border-color:#d8b8b3;padding:6px 10px">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">No courses created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $courses->links() }}</div>
    </div>
@endsection
