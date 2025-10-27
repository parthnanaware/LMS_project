<?php

namespace App\Http\Controllers;

use App\Models\tbl_corse;
use Illuminate\Http\Request;

class trialController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'course_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // image validation
            'course_description' => 'required|string',
            'subject' => 'required|array',
            'subject.*' => 'exists:tbl_subject,subject_id',  // make sure each selected subject exists in the database
        ]);

        // Handle the image upload
        $courseImage = $request->file('course_image');
        $imagePath = $courseImage->store('courses', 'public');  // Save image in the 'courses' folder in storage

        // Create the course record
        $course = tbl_corse::create([
            'course_name' => $validated['course_name'],
            'course_image' => $imagePath,
            'course_description' => $validated['course_description'],
        ]);

        // Attach selected subjects to the course using the pivot table
        $course->subjects()->sync($validated['subject']);  // sync will update the pivot table

        // Redirect to the course list with a success message
        return redirect()->route('courselist')->with('success', 'Course added successfully!');
    }
}


