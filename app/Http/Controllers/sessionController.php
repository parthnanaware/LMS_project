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
        'pdf' => 'nullable|file|mimes:pdf|max:10240',
        'task' => 'nullable|file|mimes:pdf|max:10240',
        'exam' => 'nullable|file|mimes:pdf|max:10240',
    ]);

    if ($request->hasFile('pdf')) {
        $data['pdf'] = $request->file('pdf')->store('sessions/pdfs', 'public');
    }

    if ($request->hasFile('task')) {
        $data['task'] = $request->file('task')->store('sessions/pdfs', 'public');
    }

    if ($request->hasFile('exam')) {
        $data['exam'] = $request->file('exam')->store('sessions/pdfs', 'public');
    }

    // create session
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


    //api controller





    public function getBySection($section_id)
    {
        $sessions = tbl_session::where('section_id', $section_id)->get();

        $normalized = $sessions->map(function($s) {
            return $this->normalizeSession($s);
        });

        return response()->json([
            'status' => 'success',
            'data' => $normalized
        ], 200);
    }


    public function getSession($id)
    {
        $s = tbl_session::find($id);

        if (!$s) {
            return response()->json(['status' => 'error', 'message' => 'Session not found'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $this->normalizeSession($s)
        ], 200);
    }


    protected function normalizeSession(tbl_session $s)
    {
        $sessionId = $s->id ?? $s->session_id ?? null;

        $videoUrl = null;
        if (!empty($s->video) && Storage::disk('public')->exists($s->video)) {
            $videoUrl = Storage::disk('public')->url($s->video);
        } elseif (!empty($s->video) && preg_match('/^https?:\\/\\//', $s->video)) {
            $videoUrl = $s->video;
        }

        $pdfUrl = null;
        if (!empty($s->pdf) && Storage::disk('public')->exists($s->pdf)) {
            $pdfUrl = Storage::disk('public')->url($s->pdf);
        }

        $taskUrl = null;
        if (!empty($s->task) && Storage::disk('public')->exists($s->task)) {
            $taskUrl = Storage::disk('public')->url($s->task);
        }

        $examUrl = null;
        if (!empty($s->exam) && Storage::disk('public')->exists($s->exam)) {
            $examUrl = Storage::disk('public')->url($s->exam);
        }

        return [
            'session_id'   => $sessionId,
            'section_id'   => $s->section_id ?? $s->sub_section_id ?? null,
            'title'        => $s->titel ?? $s->title ?? null,
            'type'         => $s->type ?? null,
            'video_url'    => $videoUrl,
            'pdf_url'      => $pdfUrl,
            'task_url'     => $taskUrl,
            'exam_url'     => $examUrl,
            'description'  => $s->dis ?? $s->description ?? null,
            'raw'          => $s,
        ];
    }
}


