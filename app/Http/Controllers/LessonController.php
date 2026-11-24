<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\StudentProgress;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    private function authorizeCourseEditor(Course $course): void
    {
        abort_unless(
            auth()->user()->role === 'admin'
            || (auth()->user()->role === 'instructor' && $course->instructor_id === auth()->id()),
            403,
            'You are not authorized to manage lessons for this course.'
        );
    }

    public function store(Request $request, Course $course)
    {
        $this->authorizeCourseEditor($course);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'content' => ['nullable', 'string'],
            'video_url' => ['nullable', 'url', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $course->lessons()->create($data);

        return back()->with('success', 'Lesson added.');
    }

    public function show(Course $course, Lesson $lesson)
    {
        abort_unless($lesson->course_id === $course->id, 404);

        $role = auth()->user()->role;

        if ($role === 'student') {
            abort_unless(
                Enrollment::where('student_id', auth()->id())
                    ->where('course_id', $course->id)
                    ->exists(),
                403,
                'Enroll in this course to access its lessons.'
            );

            abort_unless($lesson->is_published, 404);
        } else {
            $this->authorizeCourseEditor($course);
        }

        return view('lessons.show', compact('course', 'lesson'));
    }

    public function edit(Course $course, Lesson $lesson)
    {
        abort_unless($lesson->course_id === $course->id, 404);
        $this->authorizeCourseEditor($course);

        return view('lessons.edit', compact('course', 'lesson'));
    }

    public function update(Request $request, Course $course, Lesson $lesson)
    {
        abort_unless($lesson->course_id === $course->id, 404);
        $this->authorizeCourseEditor($course);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'content' => ['nullable', 'string'],
            'video_url' => ['nullable', 'url', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $lesson->update($data);

        return redirect()->route('lessons.show', [$course, $lesson])
            ->with('success', 'Lesson updated successfully.');
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        abort_unless($lesson->course_id === $course->id, 404);
        $this->authorizeCourseEditor($course);

        $lesson->delete();

        return redirect()->route('courses.show', $course)
            ->with('success', 'Lesson deleted.');
    }

    public function complete(Course $course, Lesson $lesson)
    {
        abort_unless(auth()->user()->role === 'student', 403);
        abort_unless($lesson->course_id === $course->id, 404);
        abort_unless($lesson->is_published, 404);

        $enrollment = Enrollment::where('student_id', auth()->id())
            ->where('course_id', $course->id)
            ->firstOrFail();

        StudentProgress::updateOrCreate(
            ['enrollment_id' => $enrollment->id, 'lesson_id' => $lesson->id],
            ['completed_at' => now()]
        );

        $total = $course->lessons()->where('is_published', true)->count();
        $done = $enrollment->progress()->whereNotNull('completed_at')->count();

        if ($total > 0 && $done >= $total) {
            $enrollment->update(['status' => 'completed']);
        }

        return back()->with('success', 'Lesson marked as completed.');
    }
}
