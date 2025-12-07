<?php

namespace App\Http\Controllers;

use App\Models\tbl_corse;
use App\Models\tbl_enrolment;
use App\Models\User;
use Illuminate\Http\Request;

class enrolmentController extends Controller
{
    // ---------------------------------------------------------
    // LIST PAGE (with course + student)
    // ---------------------------------------------------------
    public function index()
    {
        $enrolments = tbl_enrolment::with(['student', 'course'])->get();
        return view('enrolment.index', compact('enrolments'));
    }

    // ---------------------------------------------------------
    // CREATE PAGE
    // ---------------------------------------------------------
    public function create()
    {
        $students = User::where('role', 'student')->get();
        $courses = tbl_corse::all();

        return view('enrolment.create', compact('students', 'courses'));
    }

    // ---------------------------------------------------------
    // STORE NEW ENROLMENT
    // ---------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:tbl_corse,course_id',
            'mrp' => 'required|numeric',
            'sell_price' => 'required|numeric'
        ]);

        tbl_enrolment::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'mrp' => $request->mrp,
            'sell_price' => $request->sell_price,
            'status' => 'pending'
        ]);

        return redirect()->route('enrolment.index')
                         ->with('success', 'Enrolment added successfully');
    }

    // ---------------------------------------------------------
    // EDIT PAGE
    // ---------------------------------------------------------
    public function edit($id)
    {
        $enrolment = tbl_enrolment::with(['student', 'course'])->findOrFail($id);
        return view('enrolment.edit', compact('enrolment'));
    }

    // ---------------------------------------------------------
    // UPDATE ENROLMENT
    // ---------------------------------------------------------
    public function update(Request $request, $id)
    {
        $request->validate([
            'mrp' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'status' => 'required|in:paid,pending,reject'
        ]);

        $enrolment = tbl_enrolment::findOrFail($id);
        $enrolment->update($request->all());

        return redirect()->route('enrolment.index')
                         ->with('success', 'Enrolment updated successfully');
    }

    // ---------------------------------------------------------
    // ⭐ UPDATE ONLY STATUS — DIRECTLY FROM INDEX PAGE
    // ---------------------------------------------------------
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,reject'
        ]);

        $enrolment = tbl_enrolment::findOrFail($id);
        $enrolment->status = $request->status;
        $enrolment->save();

        return back()->with('success', 'Status updated successfully!');
    }

    // ---------------------------------------------------------
    // DELETE
    // ---------------------------------------------------------
    public function destroy($id)
    {
        tbl_enrolment::findOrFail($id)->delete();

        return redirect()->route('enrolment.index')
                         ->with('success', 'Enrolment deleted successfully');
    }
}
