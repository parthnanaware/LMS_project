<?php

namespace App\Http\Controllers;

use App\Models\tbl_corse;
use App\Models\tbl_subject;
use Illuminate\Http\Request;

class CorseController extends Controller
{
    /**
     * Show list of all courses (WEB)
     */
    public function index()
    {
        $courses = tbl_corse::all();
        return view('corse.index', compact('courses'));
    }

    /**
     * Show form to create a new course (WEB)
     */
    public function create()
    {
        $subjects = tbl_subject::all();
        return view('corse.create', compact('subjects'));
    }

    /**
     * Store new course (WEB)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name'        => 'required|string|max:255',
            'course_description' => 'required|string',
            'mrp'                => 'required|string',
            'sell_price'         => 'required|string',
            'course_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'subject_id'         => 'required|array',
            'subject_id.*'       => 'exists:tbl_subject,subject_id',
        ]);

        $course = new tbl_corse();
        $course->course_name        = $validated['course_name'];
        $course->course_description = $validated['course_description'];
        $course->mrp                = $validated['mrp'];
        $course->sell_price         = $validated['sell_price'];
        // cast 'array' मुळे हे DB मध्ये JSON म्हणून save होईल
        $course->subject_id         = $validated['subject_id'];

        if ($request->hasFile('course_image')) {
            $image     = $request->file('course_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/course_images'), $imageName);
            $course->course_image = $imageName;
        }

        $course->save();

        return redirect()->route('courselist')
            ->with('success', 'Course added successfully!');
    }

    /**
     * Show form to edit an existing course (WEB)
     */
    public function edit($id)
    {
        $course   = tbl_corse::findOrFail($id);
        $subjects = tbl_subject::all();

        // subject_id आधीच array आहे (cast मुळे), त्यामुळे json_decode ची गरज नाही
        return view('corse.edit', compact('course', 'subjects'));
    }

    /**
     * Update an existing course (WEB)
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'course_name'        => 'required|string|max:255',
            'course_description' => 'required|string',
            'mrp'                => 'required|string',
            'sell_price'         => 'required|string',
            'course_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'subject_id'         => 'required|array',
            'subject_id.*'       => 'exists:tbl_subject,subject_id',
        ]);

        $course = tbl_corse::findOrFail($id);

        $course->course_name        = $validated['course_name'];
        $course->course_description = $validated['course_description'];
        $course->mrp                = $validated['mrp'];
        $course->sell_price         = $validated['sell_price'];
        $course->subject_id         = $validated['subject_id'];

        if ($request->hasFile('course_image')) {
            if ($course->course_image &&
                file_exists(public_path('storage/course_images/' . $course->course_image))) {
                unlink(public_path('storage/course_images/' . $course->course_image));
            }

            $image     = $request->file('course_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/course_images'), $imageName);
            $course->course_image = $imageName;
        }

        $course->save();

        return redirect()->route('courselist')
            ->with('success', 'Course updated successfully!');
    }

    /**
     * Delete a course (WEB)
     */
    public function destroy($id)
    {
        $course = tbl_corse::findOrFail($id);

        if ($course->course_image &&
            file_exists(public_path('storage/course_images/' . $course->course_image))) {
            unlink(public_path('storage/course_images/' . $course->course_image));
        }

        $course->delete();

        return redirect()->route('courselist')
            ->with('success', 'Course deleted successfully!');
    }

    // -------------------------------------------------------------------------
    // API METHODS
    // -------------------------------------------------------------------------

    /**
     * API: Get all courses
     */
    public function apiGetCourses()
    {
        $courses = tbl_corse::all()->map(function ($c) {
            // subject_id आधीच array आहे (casts)
            $c->course_image_url = $c->course_image
                ? url('storage/course_images/' . $c->course_image)
                : null;
            return $c;
        });

        return response()->json([
            'status' => 'success',
            'data'   => $courses,
        ], 200);
    }

    /**
     * API: Get single course
     */
    public function apiGetCourseById($id)
    {
        $course = tbl_corse::find($id);

        if (!$course) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Course not found',
            ], 404);
        }

        // subject_id is already array because of cast
        $subjectIds = $course->subject_id ?? [];
        if (!is_array($subjectIds)) {
            $subjectIds = [];
        }

        $subjects = [];
        if (!empty($subjectIds)) {
            $subjects = tbl_subject::whereIn('subject_id', $subjectIds)
                ->get()
                ->map(function ($s) {
                    return [
                        'subject_id'   => $s->subject_id,
                        'subject_name' => $s->subject_name,
                        'description'  => $s->subject_des,
                    ];
                })->toArray();
        }

        $course->subjects         = $subjects;
        $course->course_image_url = $course->course_image
            ? url('storage/course_images/' . $course->course_image)
            : null;

        return response()->json([
            'status' => 'success',
            'data'   => $course,
        ], 200);
    }

    /**
     * API: Create course
     */
    public function apiCreateCourse(Request $request)
    {
        $validated = $request->validate([
            'course_name'        => 'required|string|max:255',
            'course_description' => 'required|string',
            'mrp'                => 'required',
            'sell_price'         => 'required',
            'course_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'subject_id'         => 'required|array',
            'subject_id.*'       => 'exists:tbl_subject,subject_id',
        ]);

        $course = new tbl_corse();
        $course->course_name        = $validated['course_name'];
        $course->course_description = $validated['course_description'];
        $course->mrp                = $validated['mrp'];
        $course->sell_price         = $validated['sell_price'];
        // array assign → cast handles JSON
        $course->subject_id         = $validated['subject_id'];

        if ($request->hasFile('course_image')) {
            $image     = $request->file('course_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/course_images', $imageName);
            $course->course_image = $imageName;
        }

        $course->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Course created',
            'data'    => $course,
        ], 201);
    }

    /**
     * API: Update course
     */
    public function apiUpdateCourse(Request $request, $id)
    {
        $course = tbl_corse::find($id);
        if (!$course) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Course not found',
            ], 404);
        }

        $validated = $request->validate([
            'course_name'        => 'required|string|max:255',
            'course_description' => 'required|string',
            'mrp'                => 'required',
            'sell_price'         => 'required',
            'course_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'subject_id'         => 'required|array',
            'subject_id.*'       => 'exists:tbl_subject,subject_id',
        ]);

        $course->course_name        = $validated['course_name'];
        $course->course_description = $validated['course_description'];
        $course->mrp                = $validated['mrp'];
        $course->sell_price         = $validated['sell_price'];
        $course->subject_id         = $validated['subject_id'];

        if ($request->hasFile('course_image')) {
            if ($course->course_image &&
                file_exists(storage_path('app/public/course_images/' . $course->course_image))) {
                unlink(storage_path('app/public/course_images/' . $course->course_image));
            }

            $image     = $request->file('course_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/course_images', $imageName);
            $course->course_image = $imageName;
        }

        $course->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Course updated',
            'data'    => $course,
        ], 200);
    }

    /**
     * API: Delete course
     */
    public function apiDeleteCourse($id)
    {
        $course = tbl_corse::find($id);
        if (!$course) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Course not found',
            ], 404);
        }

        if ($course->course_image &&
            file_exists(storage_path('app/public/course_images/' . $course->course_image))) {
            unlink(storage_path('app/public/course_images/' . $course->course_image));
        }

        $course->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Course deleted',
        ], 200);
    }

    /**
     * API: Get subjects of a course
     * GET /api/subjects/courses/{course_id}
     */
public function getSubjectsByCourse($course_id)
{
    $course = tbl_corse::find($course_id);

    if (!$course) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Course not found',
        ], 404);
    }

    // subject_id already cast to array
    $subjectIds = $course->subject_id ?? [];

    if (!is_array($subjectIds)) {
        $subjectIds = [];
    }

    // Fetch only subjects in this course
    $subjects = tbl_subject::whereIn('subject_id', $subjectIds)->get();

    $formatted = $subjects->map(function ($s) {
        return [
            'subject_id'   => $s->subject_id,
            'subject_name' => $s->subject_name,
            'description'  => $s->subject_des,
            'subject_img'  => $s->subject_img ? url($s->subject_img) : null,
        ];
    });

    return response()->json([
        'status' => 'success',
        'data'   => $formatted,
    ], 200);
}

}
