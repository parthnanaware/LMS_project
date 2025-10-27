<?php

namespace App\Http\Controllers;

use App\Models\tbl_corse;
use App\Models\tbl_subject;
use Illuminate\Http\Request;

class CorseController extends Controller
{
    /**
     * Display a listing of the resource.
     */public function index()
{
    $courses = tbl_corse::with('subject')->get();
    return view('corse.index', compact('courses'));
}

 public function store(Request $request)
{

    $validated = $request->validate([
        'course_name' => 'required|string|max:255',
        'course_description' => 'required|string',
        'course_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'tbl_subject' => 'required|array',
        'tbl_subject.*' => 'exists:tbl_subject,subject_id',
    ]);


    $course = new tbl_corse();

    $course->course_name = $validated['course_name'];
    $course->course_description = $validated['course_description'];


    if ($request->hasFile('course_image')) {
        $image = $request->file('course_image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();


        $image->move(public_path('storage/course_images'), $imageName);

        $course->course_image = $imageName;
    }


    $course->save();


    $course->tbl_subject()->attach($validated['tbl_subject']);


    return redirect('/courselist')->with('success', 'Course added successfully!');
}
public function create()
{
    $subjects = tbl_subject::all();
    return view('corse.create', compact('subjects'));
}

}
