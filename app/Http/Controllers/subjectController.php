<?php

namespace App\Http\Controllers;

use App\Models\tbl_corse;
use App\Models\tbl_subject;
use Illuminate\Http\Request;

class subjectController extends Controller
{
public function index()
{
    $subject = tbl_subject::all();
    return view('subject.index', compact('subject'));
}

    public function create()
    {
       return view('subject.create');
    }
    
    public function store(Request $request, tbl_subject $subject)
{
    $request->validate([
        'subject_name' => 'required|string',

        'subject_img'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'subject_des'  => 'required|string',
    ]);

    $subject->subject_name = $request->subject_name;

    $subject->subject_des  = $request->subject_des;

    if ($request->hasFile('subject_img')) {
        $subject->subject_img = $request->file('subject_img')->store('sub', 'public');
    }


    $subject->save();

    return redirect()->route('subject.index')->with('success', 'Subject created successfully.');
}



public function update(Request $request, tbl_subject $subject)
{

    $request->validate([
     'subject_name' => 'required|string|max:255',
     'subject_des'  => 'required|string',
     'subject_img'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

    ]);

    $subject->subject_name = $request->subject_name;

    $subject->subject_des  = $request->subject_des;

    if ($request->hasFile('subject_img')) {

        $subject->subject_img = $request->file('subject_img')->store('sub', 'public');
    }

    $subject->save();

    return redirect()->route('subject.index')->with('success', 'Subject updated successfully.');
}



    public function show(string $id)
    {
        //
    }

    public function edit(tbl_subject $subject)
    {

        return view('subject.edit',compact('subject'));
    }


    public function destroy(tbl_subject $subject)
    {
       $subject->delete();

    return redirect()->route('subject.index')->with('success', 'Student deleted successfully.');

    }

// public function getSubjectsByCourse($course_id)
// {
//     // Find course
//     $course = tbl_corse::find($course_id);

//     if (!$course) {
//         return response()->json([
//             'status'  => 'error',
//             'message' => 'Course not found'
//         ], 404);
//     }

//     // subject_id is already an ARRAY because of cast
//     $subjectIds = $course->subject_id ?? [];

//     // Must be array
//     if (!is_array($subjectIds)) {
//         $subjectIds = [];
//     }

//     // Fetch subjects
//     $subjects = tbl_subject::whereIn('subject_id', $subjectIds)->get();

//     // Normalize
//     $normalized = $subjects->map(function ($s) {
//         return [
//             'subject_id'   => $s->subject_id,
//             'subject_name' => $s->subject_name,
//             'description'  => $s->subject_des ?? null,
//             'subject_img'  => $s->subject_img ?? null
//         ];
//     });

//     return response()->json([
//         'status' => 'success',
//         'data'   => $normalized
//     ], 200);
// }

public function getSubjectById($id)
{
    $subject = tbl_subject::find($id);

    if (!$subject) {
        return response()->json([
            'status' => 'error',
            'message' => 'Subject not found'
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'data' => [
            'subject_id' => $subject->subject_id,
            'subject_name' => $subject->subject_name,
            'description' => $subject->subject_des,
            'subject_img' => $subject->subject_img ? url($subject->subject_img) : null,
        ]
    ]);
}

}
