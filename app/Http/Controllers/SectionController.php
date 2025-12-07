<?php

namespace App\Http\Controllers;

use App\Models\tbl_section;
use App\Models\tbl_subject;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index($subject_id = null)
    {
        $subjects = tbl_subject::all();
        $sections = $subject_id
            ? tbl_section::where('sub_id', $subject_id)->get()
            : tbl_section::all();

        return view('section.index', compact('sections', 'subjects', 'subject_id'));
    }

public function create($subject_id = null)
    {
        $sub = tbl_subject::all();
        $selectedSubjectId = $subject_id;
        return view('section.create', compact('sub', 'selectedSubjectId'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'tital' => 'required|string',
            'dis' => 'required|string',
            'sub_id' => 'required|integer',
        ]);

        tbl_section::create($request->all());

    return redirect()->route('section.bySubject', ['subject_id' => $request->sub_id])
                     ->with('success', 'Added successfully!');
    }

    public function edit(tbl_section $section)
    {
        $subjects = tbl_subject::all();
        return view('section.edit', compact('section', 'subjects'));
    }

    public function update(Request $request, tbl_section $section)
    {
        $request->validate([
            'tital' => 'required|string',
            'dis' => 'required|string',
            'sub_id' => 'required|integer',
        ]);

        $section->update($request->all());
return redirect()->route('section.bySubject', ['subject_id' => $request->sub_id])
                     ->with('success', 'Added successfully!');

    }

    public function destroy($id)
    {
        $section = tbl_section::findOrFail($id);
        $section->delete();

        return back()->with('success', 'Section deleted successfully.');
    }




    public function getSectionsBySubject($subject_id)
{
    $sections = tbl_section::where('sub_id', $subject_id)->get();

    $normalized = $sections->map(function($s) {
        return [
            'section_id'   => $s->id,
            'subject_id'   => $s->sub_id,
            'section_name' => $s->tital,
            'description'  => $s->dis,
            'resource'     => $s->resource ?? null
        ];
    });

    return response()->json([
        'status' => 'success',
        'data'   => $normalized
    ], 200);
}


}




