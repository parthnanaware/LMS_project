<?php

namespace App\Http\Controllers;

use App\Models\tbl_corse;
use App\Models\tbl_enrolment;
use App\Models\User;
use Illuminate\Http\Request;

class enrolmentController extends Controller
{
    public function index()
    {
        $enrolments = tbl_enrolment::with('student', 'course')->get();
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
            $course = tbl_corse::where('course_id', $selectedCourseId)->first();
            if ($course) {
                $mrp = $course->mrp;
                $sell_price = $course->sell_price;
            }
        }

        return view('enrolment.create', compact(
            'students',
            'courses',
            'selectedCourseId',
            'mrp',
            'sell_price'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id'  => 'required|exists:tbl_corse,course_id',
            'mrp'        => 'required|numeric',
            'sell_price' => 'required|numeric',
        ]);

        tbl_enrolment::create([
            'student_id' => $request->student_id,
            'course_id'  => $request->course_id,
            'mrp'        => $request->mrp,
            'sell_price' => $request->sell_price,
        ]);

        return redirect()
            ->route('enrolment.index')
            ->with('success', 'Enrolment added (Pending)');
    }

    public function edit($id)
    {
        $enrolment = tbl_enrolment::findOrFail($id);
        $students = User::where('role', 'student')->get();
        $courses = tbl_corse::all();

        return view('enrolment.edit', compact(
            'enrolment',
            'students',
            'courses'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id'  => 'required|exists:tbl_corse,course_id',
            'mrp'        => 'required|numeric',
            'sell_price' => 'required|numeric',
        ]);

        $enrolment = tbl_enrolment::findOrFail($id);
        $enrolment->update([
            'student_id' => $request->student_id,
            'course_id'  => $request->course_id,
            'mrp'        => $request->mrp,
            'sell_price' => $request->sell_price,
        ]);

        return redirect()
            ->route('enrolment.index')
            ->with('success', 'Enrolment updated');
    }

    public function destroy($id)
    {
        tbl_enrolment::findOrFail($id)->delete();

        return redirect()
            ->route('enrolment.index')
            ->with('success', 'Enrolment deleted');
    }

    public function getCoursePrice($id)
    {
        $course = tbl_corse::where('course_id', $id)->first();

        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        return response()->json([
            'mrp' => $course->mrp,
            'sell_price' => $course->sell_price,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,reject'
        ]);

        $enrolment = tbl_enrolment::findOrFail($id);
        $enrolment->status = $request->status;
        $enrolment->save();

        return redirect()->back()->with('success', 'Status updated');
    }

    public function myEnrolments(Request $request)
    {
        $user = $request->user();

        if (!$user || $user->role !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $enrolments = tbl_enrolment::with('course')
            ->where('student_id', $user->id)
            ->where('status', 'pending') 
            ->get();

        return response()->json([
            'success' => true,
            'data' => $enrolments
        ]);
    }
}
