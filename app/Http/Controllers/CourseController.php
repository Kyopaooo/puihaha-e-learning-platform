<?php
namespace App\Http\Controllers;

use App\Models\{Course, CourseCategory, MembershipLevel, Enrollment};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['instructor', 'category'])
            ->where('status', 'published')->latest()->paginate(12);

        return view('courses.index', compact('courses'));
    }

    public function manage()
    {
        abort_unless(in_array(auth()->user()->role, ['admin', 'instructor']), 403);
        $courses = Course::with('category')
            ->when(auth()->user()->role === 'instructor', fn ($q) => $q->where('instructor_id', auth()->id()))
            ->latest()->paginate(15);

        return view('courses.manage', compact('courses'));
    }

    public function create()
    {
        abort_unless(in_array(auth()->user()->role, ['admin', 'instructor']), 403);

        return view('courses.form', [
            'course' => new Course,
            'categories' => CourseCategory::all(),
            'levels' => MembershipLevel::all(),
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(in_array(auth()->user()->role, ['admin', 'instructor']), 403);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string'],
            'course_category_id' => ['nullable', 'exists:course_categories,id'],
            'required_membership_level_id' => ['nullable', 'exists:membership_levels,id'],
            'status' => ['required', 'in:draft,published,archived'],
        ]);
        $data['slug'] = Str::slug($data['title']).'-'.Str::lower(Str::random(5));
        $data['instructor_id'] = auth()->id();
        Course::create($data);

        return redirect()->route('courses.manage')->with('success', 'Course created.');
    }

    public function show(Course $course)
    {
        abort_unless(
            $course->status === 'published' || in_array(auth()->user()->role, ['admin', 'instructor']),
            404
        );

        $course->load(['instructor', 'category', 'lessons.materials']);
        $enrollment = Enrollment::with('progress')
            ->where('student_id', auth()->id())
            ->where('course_id', $course->id)
            ->first();
        $enrolled = (bool) $enrollment;

        $publishedLessonIds = $course->lessons()
            ->where('is_published', true)
            ->pluck('id')
            ->all();

        $completedLessonIds = $enrollment
            ? $enrollment->progress()->whereNotNull('completed_at')->pluck('lesson_id')->all()
            : [];

        $publishedLessonCount = count($publishedLessonIds);
        $completedCount = count(array_intersect($publishedLessonIds, $completedLessonIds));
        $progressPercent = $publishedLessonCount > 0
            ? (int) round(($completedCount / $publishedLessonCount) * 100)
            : 0;

        return view('courses.show', compact(
            'course', 'enrolled', 'enrollment', 'completedLessonIds',
            'publishedLessonCount', 'completedCount', 'progressPercent'
        ));
    }

    public function edit(Course $course)
    {
        abort_unless(auth()->user()->role === 'admin' || $course->instructor_id === auth()->id(), 403);

        return view('courses.form', [
            'course' => $course,
            'categories' => CourseCategory::all(),
            'levels' => MembershipLevel::all(),
        ]);
    }

    public function update(Request $request, Course $course)
    {
        abort_unless(auth()->user()->role === 'admin' || $course->instructor_id === auth()->id(), 403);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string'],
            'course_category_id' => ['nullable', 'exists:course_categories,id'],
            'required_membership_level_id' => ['nullable', 'exists:membership_levels,id'],
            'status' => ['required', 'in:draft,published,archived'],
        ]);
        $course->update($data);

        return back()->with('success', 'Course updated.');
    }

    public function destroy(Course $course)
    {
        $user = auth()->user();

        abort_unless(
            $user->role === 'admin'
            || ($user->role === 'instructor' && (int) $course->instructor_id === (int) $user->id),
            403
        );

        // Collect uploaded lesson-material paths before the database cascades delete the related rows.
        $materialPaths = $course->lessons()
            ->with('materials')
            ->get()
            ->flatMap(fn ($lesson) => $lesson->materials->pluck('file_path'))
            ->filter()
            ->unique()
            ->values()
            ->all();

        // The foreign keys in the learning-table migration cascade-delete lessons,
        // learning-material records, enrollments, and student progress.
        $course->delete();

        // Remove the corresponding uploaded files from Laravel's default storage disk.
        if (! empty($materialPaths)) {
            Storage::delete($materialPaths);
        }

        return redirect()->route('courses.manage')->with('success', 'Course deleted.');
    }

    public function enroll(Course $course)
    {
        abort_unless(auth()->user()->role === 'student', 403);
        abort_unless($course->status === 'published', 404);

        $member = auth()->user()->member;
        if ($course->required_membership_level_id) {
            abort_unless(
                $member
                && (int) $member->membership_level_id === (int) $course->required_membership_level_id
                && $member->status === 'Active',
                403,
                'Your membership does not grant access to this course.'
            );
        }

        Enrollment::firstOrCreate(
            ['student_id' => auth()->id(), 'course_id' => $course->id],
            ['status' => 'active', 'enrolled_at' => now()]
        );

        return redirect()->route('courses.show', $course)->with('success', 'You are enrolled in this course.');
    }
}
