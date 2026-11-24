<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\LearningMaterial;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LearningMaterialController extends Controller
{
    private function canManage(Course $course): bool
    {
        return auth()->user()->role === 'admin'
            || (auth()->user()->role === 'instructor' && $course->instructor_id === auth()->id());
    }

    public function store(Request $request, Course $course, Lesson $lesson)
    {
        abort_unless($lesson->course_id === $course->id, 404);
        abort_unless($this->canManage($course), 403);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'file' => ['required', 'file', 'max:20480', 'mimes:pdf,doc,docx,ppt,pptx,txt,jpg,jpeg,png,mp4'],
        ]);

        $path = $request->file('file')->store('learning-materials');

        $lesson->materials()->create([
            'title' => $data['title'],
            'file_path' => $path,
            'original_name' => $request->file('file')->getClientOriginalName(),
        ]);

        return back()->with('success', 'Learning material uploaded.');
    }

    public function download(Course $course, Lesson $lesson, LearningMaterial $material)
    {
        abort_unless($lesson->course_id === $course->id, 404);
        abort_unless($material->lesson_id === $lesson->id, 404);

        if ($this->canManage($course)) {
            // Course owner and administrator may preview materials, including draft lessons.
        } else {
            abort_unless(auth()->user()->role === 'student', 403);
            abort_unless($lesson->is_published, 404);
            abort_unless(
                Enrollment::where('student_id', auth()->id())
                    ->where('course_id', $course->id)
                    ->exists(),
                403
            );
        }

        abort_unless(Storage::exists($material->file_path), 404);

        return Storage::download($material->file_path, $material->original_name);
    }
}
