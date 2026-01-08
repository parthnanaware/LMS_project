<?php

namespace App\Http\Controllers;

use App\Models\SessionProgress;
use App\Models\tbl_session;
use App\Models\tbl_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = tbl_session::all();
        return view('session.index', compact('sessions'));
    }

public function bySection($section_id)
{
    $sessions = tbl_session::where('section_id', $section_id)
        ->orderBy('id')
        ->get()
        ->groupBy('section_id');

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
public function edit($id)
{
    $session = tbl_session::findOrFail($id);
    $sections = tbl_section::all();

    return view('session.edit', compact('session', 'sections'));
}

    public function store(Request $request)
    {
        $request->validate([
            'titel'      => 'required|string|max:255',
            'type'       => 'required|string|max:50',
            'section_id' => 'required|integer',
        ]);

        tbl_session::create($request->only('titel', 'type', 'section_id'));

        return redirect()
            ->route('session.bySection', $request->section_id)
            ->with('success', 'Session created successfully!');
    }


public function update(Request $request, $id)
{
    $session = tbl_session::findOrFail($id);

    $rules = [
        'titel'      => 'required|string|max:255',
        'section_id' => 'required|integer',
        'type'       => 'required|string',
    ];

    // type-based validation
    if ($session->type === 'video') {
        $rules['video'] = 'required|string';
    }

    if ($session->type === 'pdf') {
        $rules['pdf'] = 'nullable|file|mimes:pdf|max:10240';
    }

    $request->validate($rules);

    $data = $request->only('titel', 'section_id');

    // UPDATE BASED ON TYPE
    if ($session->type === 'video') {
        $data['video'] = $request->video;
    }

    if ($session->type === 'pdf' && $request->hasFile('pdf')) {

        if ($session->pdf) {
            Storage::disk('public')->delete($session->pdf);
        }

        $data['pdf'] = $request->file('pdf')
            ->store('sessions/pdf', 'public');
    }

    $session->update($data);

    return redirect()
        ->route('session.bySection', $session->section_id)
        ->with('success', 'Session updated successfully!');
}



public function destroy($id)
{
    $session = tbl_session::findOrFail($id);

    // Optional: delete related progress
    SessionProgress::where('session_id', $id)->delete();

    // Optional: delete stored files
    if ($session->pdf) {
        Storage::disk('public')->delete($session->pdf);
    }
    if ($session->task) {
        Storage::disk('public')->delete($session->task);
    }
    if ($session->exam) {
        Storage::disk('public')->delete($session->exam);
    }

    $sectionId = $session->section_id;
    $session->delete();

    return redirect()
        ->route('session.bySection', $sectionId)
        ->with('success', 'Session deleted successfully!');
}

public function getBySection(Request $request, $section_id)
{
    $userId = $request->query('user_id');

    $sessions = tbl_session::where('section_id', $section_id)
        ->orderBy('id')
        ->get();

    $data = [];

    foreach ($sessions as $session) {
        $progress = SessionProgress::where('user_id', $userId)
            ->where('session_id', $session->id)
            ->first();

        $data[] = [
            'session_id' => $session->id,
            'title'      => $session->titel,
            'type'       => $session->type,
            'is_locked'  => (int) $session->is_locked,
            'pdf_status' => $progress?->pdf_status,
        ];
    }

    return response()->json([
        'status' => 'success',
        'data'   => $data,
    ]);


}




public function uploadStep(Request $request)
{
    $request->validate([
        'user_id'    => 'required|integer',
        'session_id' => 'required|integer|exists:session,id',
        'file'       => 'required|file|mimes:pdf|max:10240',
    ]);

    // 1️⃣ Get session with section
    $session = tbl_session::with('section')->findOrFail($request->session_id);

    // 2️⃣ Store PDF
    $path = $request->file('file')->store(
        "progress/{$request->user_id}/{$session->id}",
        'public'
    );

    // 3️⃣ Save / Update progress WITH ALL IDs
    SessionProgress::updateOrCreate(
        [
            'user_id'    => $request->user_id,
            'session_id' => $session->id,
        ],
        [
            'course_id'  => $session->section->course_id,
            'subject_id' => $session->section->subject_id,
            'section_id' => $session->section_id,
            'pdf_file'   => $path,
            'pdf_status' => 'pending',
        ]
    );

    return response()->json([
        'status'  => 'success',
        'message' => 'PDF uploaded, waiting for admin approval',
    ]);
}


    public function sessionProgress(Request $request)
    {
        $progress = SessionProgress::where([
            'user_id'    => $request->user_id,
            'session_id' => $request->session_id,
        ])->first();

        return response()->json([
            'pdf_status'  => $progress?->pdf_status ?? 'locked',
            'task_status' => $progress?->task_status ?? 'locked',
            'exam_status' => $progress?->exam_status ?? 'locked',
        ]);
    }
public function show($id)
{
    $session = tbl_session::findOrFail($id);

    return response()->json([
        'status' => 'success',
        'data' => [
            'session_id' => $session->id,
            'title'      => $session->titel,
            'type'       => $session->type,   // video | pdf
            'video'      => $session->video,  // video URL
            'pdf'        => $session->pdf,    // storage path
        ],
    ]);
}

    public function adminList()
    {
        $uploads = DB::table('tbl_session_progress')
            ->join('users', 'tbl_session_progress.user_id', '=', 'users.id')
            ->join('tbl_session', 'tbl_session_progress.session_id', '=', 'tbl_session.id')
            ->whereNotNull('tbl_session_progress.pdf_file') // ✅ FIX
            ->select(
                'tbl_session_progress.*',
                'users.name as user_name',
                'tbl_session.titel as session_title'
            )
            ->orderBy('tbl_session_progress.created_at', 'desc')
            ->get();

        return view('session_progress.index', compact('uploads'));
    }



}
