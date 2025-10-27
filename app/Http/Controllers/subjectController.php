<?php

namespace App\Http\Controllers;

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
}
