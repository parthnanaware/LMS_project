<?php

namespace App\Http\Controllers;

use App\Models\tbl_corse;
use App\Models\tbl_enrolment;
use App\Models\tbl_student;
use App\Models\User;
use Illuminate\Http\Request;

class enrolmentController extends Controller
{
     public function index()
    {
        $enrolments =tbl_enrolment::with('student')->get();  ;
        return view('enrolment.index', compact('enrolments'));
    }

 public function create(Request $request)
    {
        $students = User::where('role', 'student')->get();
        $courses = tbl_corse::all();

        $selectedCourseId = $request->get('course_id');
        $mrp = null;
        $sell_price = null;

        if ($selectedCourseId) {
            $course = tbl_corse::find($selectedCourseId);
            if ($course) {
                $mrp = $course->mrp;
                $sell_price = $course->sell_price;
            }
        }

        return view('enrolment.create', compact(
            'students', 'courses', 'selectedCourseId', 'mrp', 'sell_price'
        ));
    }

   public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:users,id',
        'course_id' => 'required|exists:tbl_corse,course_id', // <-- use correct table name
        'mrp' => 'required|numeric',
        'sell_price' => 'required|numeric',
    ]);

    $enrolment = new tbl_enrolment();
    $enrolment->student_id = $request->student_id;
    $enrolment->course_id = $request->course_id;
    $enrolment->mrp = $request->mrp;
    $enrolment->sell_price = $request->sell_price;
    $enrolment->save();

    return redirect()->route('enrolment.index')->with('success', 'Enrolment added successfully!');
}

    public function edit($id)
    {
        $enrolment = tbl_enrolment::findOrFail($id);
        $students = User::where('role', 'student')->get();
        $courses = tbl_corse::all();
        return view('enrolment.edit', compact('enrolment', 'students', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
    'student_id' => 'required|exists:users,id', // or tbl_students,id
    'course_id' => 'required|exists:tbl_corse,course_id',
    'mrp' => 'required|numeric',
    'sell_price' => 'required|numeric',
]);


        $enrolment = tbl_enrolment::findOrFail($id);
        $enrolment->update($request->all());

        return redirect()->route('enrolment.index')->with('success', 'Enrolment updated successfully!');
    }

    public function destroy($id)
    {
        $enrolment = tbl_enrolment::findOrFail($id);
        $enrolment->delete();

        return redirect()->route('enrolment.index')->with('success', 'Enrolment deleted successfully!');
    }
public function getCoursePrice($id)
{
    // Use correct model and primary key name
    $course = tbl_corse::where('course_id', $id)->first();

    if (!$course) {
        return response()->json(['error' => 'Course not found'], 404);
    }

    return response()->json([
        'mrp' => $course->mrp,           // column in tbl_corse table
        'sell_price' => $course->sell_price, // column in tbl_corse table
    ]);
}

public function myEnrolments(Request $request)
{
    try {

        // Logged-in user check
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access. Please login again.'
            ], 401);
        }

        // Validate user role if required
        if ($user->role !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'Only students can view their enrolments.'
            ], 403);
        }

        // Fetch enrolments
        $enrolments = tbl_enrolment::with('course')
            ->where('student_id', $user->id)
            ->get();

        // If no enrolments found
        if ($enrolments->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'No enrolments found.',
                'data' => []
            ], 200);
        }

        // Success response
        return response()->json([
            'success' => true,
            'data' => $enrolments
        ], 200);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

        return response()->json([
            'success' => false,
            'message' => 'Requested data not found.',
            'error' => $e->getMessage()
        ], 404);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong on the server.',
            'error' => $e->getMessage(), // You can remove this in production
        ], 500);
    }
}





}



