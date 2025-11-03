<?php

namespace App\Http\Controllers;

use App\Models\tbl_session;
use App\Models\tbl_section;
use App\Models\tbl_subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SessionController extends Controller
{

    public function index()
    {
        
        $sessions = tbl_session::all();
        return view('session.index', compact('sessions'));
    }


    public function bySection($section_id)
{
    $sessions = tbl_session::where('section_id', $section_id)->get();
    return view('session.index', compact('sessions', 'section_id'));
}



    public function create()
    {
        $sections = tbl_section::all();
        return view('session.create', compact('sections'));

       }

    public function createForSection($section_id)
    {

     $sections = tbl_section::all();

        return view('session.create', compact('sections', 'section_id'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'titel' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'section_id' => 'required|integer',
            'video' => 'nullable|url',
            'pdf' => 'nullable|mimes:pdf|max:10240',
            'task' => 'nullable|string',
            'exam' => 'nullable|string',
        ]);

        if ($request->hasFile('pdf')) {
                  $data['pdf'] = $request->file('pdf')->store('sessions/pdfs', 'public');
        }

        tbl_session::create($data);

        if ($request->filled('section_id')) {

            return redirect()->route('session.bySection', $request->section_id)
                ->with('success', 'Session added to section successfully.');
        }

        return redirect()->route('session.index')->with('success', 'Session created successfully.');
    }

public function edit($id)
{
    $session = tbl_session::findOrFail($id);

    if (!$session->section_id) {
        return redirect()->route('session.index')
                         ->with('error', 'Session does not belong to any section.');
    }

    return view('session.edit', compact('session'));
}


    public function update(Request $request, $id)
    {
        $session = tbl_session::findOrFail($id);

        $request->validate([
            'titel' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'video' => 'nullable|mimes:mp4,avi,mov|max:20000',
            'pdf' => 'nullable|mimes:pdf|max:10000',
        ]);

        $session->titel = $request->titel;
        $session->type = $request->type;

        if ($request->hasFile('video')) {
            if ($session->video && Storage::disk('public')->exists($session->video)) {
                Storage::disk('public')->delete($session->video);
            }
            $session->video = $request->file('video')->store('videos', 'public');
        }

        if ($request->hasFile('pdf')) {
            if ($session->pdf && Storage::disk('public')->exists($session->pdf)) {
                Storage::disk('public')->delete($session->pdf);
            }
            $session->pdf = $request->file('pdf')->store('pdfs', 'public');
        }

        $session->save();

return redirect()->route('session.bySection', ['section_id' => $request->section_id ?? 0])
                 ->with('success', 'Session updated successfully!');

        // return redirect()->route('session.index')->with('success', 'Session updated successfully!');
    }
    public function destroy(tbl_session $session)
    {
        if ($session->pdf && Storage::disk('public')->exists($session->pdf)) {

            Storage::disk('public')->delete($session->pdf);
        }

        $session->delete();

        return redirect()->route('session.index')->with('success', 'Session deleted successfully.');
    }
}
