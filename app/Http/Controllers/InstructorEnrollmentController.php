<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class InstructorEnrollmentController extends Controller
{
    public function index(Course $course)
    {
        abort_unless(
            auth()->user()->role === 'admin'
            || (auth()->user()->role === 'instructor' && $course->instructor_id === auth()->id()),
            403
        );

        $enrollments = $course->enrollments()
            ->with(['student', 'progress'])
            ->latest('enrolled_at')
            ->paginate(20);

        $publishedLessonIds = $course->lessons()
            ->where('is_published', true)
            ->pluck('id');

        $totalLessons = $publishedLessonIds->count();

        return view('courses.enrollments', compact(
            'course', 'enrollments', 'totalLessons', 'publishedLessonIds'
        ));
    }
}
