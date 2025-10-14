<?php

namespace App\Http\Controllers;

use App\Models\tbl_corse;
use App\Models\tbl_subject;
use Illuminate\Http\Request;

class CorseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        $subjects = tbl_subject::all();
        return view('corse.create', compact('subjects'));
    }

    /**
     * Store a newly created course in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:tbl_subject,id',
            'course_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        if ($request->hasFile('course_image')) {
            $imagePath = $request->file('course_image')->store('course_images', 'public');
        } else {
            $imagePath = null;
        }

        tbl_corse::create([
            'course_title' => $validated['name'],
            'course_description' => $validated['description'],
            'course_image' => $imagePath,
            'subject_id' => $validated['subject_id'],
        ]);

        return redirect()->route('corse.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the course list.
     */
    public function index()
    {
        $courses = tbl_corse::with('subject')->paginate(9);
        return view('corse.index', compact('courses'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
