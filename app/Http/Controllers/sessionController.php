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
        $request->validate([
            'titel'      => 'required|string|max:255',
            'type'       => 'required|string|max:50',
            'section_id' => 'required|integer',

            'video' => 'nullable|url',
            'pdf'   => 'nullable|file|mimes:pdf|max:10240',
            'task'  => 'nullable|file|mimes:pdf|max:10240',
            'exam'  => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = [
            'titel'      => $request->titel,
            'type'       => $request->type,
            'section_id' => $request->section_id,
        ];

        if ($request->type === 'video') {
            $data['video'] = $request->video;
        }

        if ($request->type === 'pdf' && $request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('sessions/pdf', 'public');
        }

        if ($request->type === 'task' && $request->hasFile('task')) {
            $data['task'] = $request->file('task')->store('sessions/task', 'public');
        }

        if ($request->type === 'exam' && $request->hasFile('exam')) {
            $data['exam'] = $request->file('exam')->store('sessions/exam', 'public');
        }

        tbl_session::create($data);

        return redirect()
            ->route('session.bySection', $request->section_id)
            ->with('success', 'Session created successfully!');
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
            'type'  => 'required|string',
            'video' => 'nullable|url',
            'pdf'   => 'nullable|mimes:pdf|max:10240',
            'task'  => 'nullable|mimes:pdf|max:10240',
            'exam'  => 'nullable|mimes:pdf|max:10240',
        ]);

        $session->titel = $request->titel;
        $session->type  = $request->type;

        if ($request->hasFile('pdf')) {
            Storage::disk('public')->delete($session->pdf);
            $session->pdf = $request->file('pdf')->store('sessions/pdf', 'public');
        }

        if ($request->hasFile('task')) {
            Storage::disk('public')->delete($session->task);
            $session->task = $request->file('task')->store('sessions/task', 'public');
        }

        if ($request->hasFile('exam')) {
            Storage::disk('public')->delete($session->exam);
            $session->exam = $request->file('exam')->store('sessions/exam', 'public');
        }

        if ($request->video) {
            $session->video = $request->video;
        }

        $session->save();

        return redirect()
            ->route('session.bySection', $session->section_id)
            ->with('success', 'Session updated successfully!');
    }

    public function destroy(tbl_session $session)
    {
        foreach (['pdf', 'task', 'exam'] as $field) {
            if ($session->$field) {
                Storage::disk('public')->delete($session->$field);
            }
        }

        $session->delete();

        return redirect()->route('session.index')->with('success', 'Session deleted successfully.');
    }

public function getBySection(Request $request, $section_id)
{
    try {
        $userId = $request->query('user_id');

        $sessions = tbl_session::where('section_id', $section_id)
            ->orderBy('id')
            ->get();

        $previousUnlocked = true;

        $data = $sessions->map(function ($session) use ($userId, &$previousUnlocked) {

            // 🔥 FORCE CREATE ROW
            $progress = SessionProgress::firstOrCreate(
                [
                    'user_id'    => $userId,
                    'session_id' => $session->id,
                ],
                [
                    'pdf_status' => 'locked',
                ]
            );

            $pdfStatus = $progress->pdf_status;

            $isLocked = !$previousUnlocked;

            // 🔓 NEXT UNLOCK RULE
            $previousUnlocked = ($pdfStatus === 'approved');

            return [
                'session_id' => $session->id,
                'title'      => $session->title,

                'pdf_status' => $pdfStatus,
                'is_locked'  => $isLocked,
                'can_upload' => !$isLocked && $pdfStatus !== 'approved',
            ];
        });

        return response()->json([
            'status' => 'success',
            'data'   => $data,
        ]);

    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'msg'    => $e->getMessage(),
        ], 500);
    }
}




    public function getSession($id)
    {
        $session = tbl_session::find($id);
        if (!$session) {
            return response()->json(['status' => 'error', 'message' => 'Session not found'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $this->normalizeSession($session),
        ]);
    }





protected function normalizeSession(tbl_session $s, $userId = null)
{
    $progress = null;

    if ($userId) {
        $progress = DB::table('tbl_session_progress')
            ->where('user_id', $userId)
            ->where('session_id', $s->id)
            ->first();
    }

    return [
        'session_id' => $s->id,
        'section_id' => $s->section_id,
        'title'      => $s->titel,
        'type'       => $s->type,

        'video_url' => $s->video,
        'pdf_url'   => $s->pdf ? Storage::disk('public')->url($s->pdf) : null,
        'task_url'  => $s->task ? Storage::disk('public')->url($s->task) : null,
        'exam_url'  => $s->exam ? Storage::disk('public')->url($s->exam) : null,

        'unlock' => [
            'video' => true,
            'pdf'   => $progress?->pdf_status === 'approved',
            'task'  => $progress?->task_status === 'approved',
            'exam'  => $progress?->exam_status === 'approved',
        ],
    ];
}




public function uploadStep(Request $request)
{
    $request->validate([
        'user_id'    => 'required|integer',
        'session_id' => 'required|integer',
        'step'       => 'required|in:video,pdf,task,exam',
        'file'       => 'required|file|mimes:pdf|max:10240',

        'course_id'  => 'nullable|integer',
        'subject_id' => 'nullable|integer',
        'section_id' => 'nullable|integer',
    ]);

    $path = $request->file('file')->store(
        "progress/{$request->user_id}/{$request->session_id}",
        'public'
    );

    // Base data (common)
    $data = [
        'course_id'  => $request->course_id,
        'subject_id' => $request->subject_id,
        'section_id' => $request->section_id,
    ];

    // Step-wise update (THIS FIXES NULL / WRONG DATA)
    if ($request->step === 'pdf') {
        $data['pdf_file']   = $path;
        $data['pdf_status'] = 'pending';
    }

    if ($request->step === 'task') {
        $data['task_file']   = $path;
        $data['task_status'] = 'pending';
    }

    if ($request->step === 'exam') {
        $data['exam_file']   = $path;
        $data['exam_status'] = 'pending';
    }

    $progress = SessionProgress::updateOrCreate(
        [
            'user_id'    => $request->user_id,
            'session_id' => $request->session_id,
        ],
        $data
    );

    return response()->json([
        'status' => 'success',
        'data'   => $progress,
    ]);
}



public function sessionProgress(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|integer',
            'session_id' => 'required|integer',
        ]);

        $progress = SessionProgress::where([
            'user_id'    => $request->user_id,
            'session_id' => $request->session_id,
        ])->first();

        return response()->json([
            'video_unlocked' => true,
            'pdf_unlocked'   => true,
            'task_unlocked'  => $progress?->pdf_status === 'approved',
            'exam_unlocked'  => $progress?->task_status === 'approved',

            'pdf_status'  => $progress?->pdf_status  ?? 'not_uploaded',
            'task_status' => $progress?->task_status ?? 'locked',
            'exam_status' => $progress?->exam_status ?? 'locked',
        ]);
    }



public function changePdfStatus(Request $request)
{
    try {
        $request->validate([
            'user_id'    => 'required|integer',
            'session_id' => 'required|integer',
            'pdf_status' => 'required|in:pending,approved,completed,rejected',
        ]);

        $progress = SessionProgress::where('user_id', $request->user_id)
            ->where('session_id', $request->session_id)
            ->first();

        if (!$progress) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Session progress not found',
            ], 404);
        }

        // Update status
        $progress->pdf_status = $request->pdf_status;
        $progress->save();

        return response()->json([
            'status'     => 'success',
            'pdf_status' => $progress->pdf_status,
        ], 200);

    } catch (\Throwable $e) {
        \Log::error('CHANGE_PDF_STATUS_ERROR', [
            'message' => $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => $e->getFile(),
        ]);

        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
}






    public function adminList()
    {
        $uploads = DB::table('tbl_session_progress')
            ->join('users', 'tbl_session_progress.user_id', '=', 'users.id')
            ->join('tbl_session', 'tbl_session_progress.session_id', '=', 'tbl_session.id')
            ->select(
                'tbl_session_progress.*',
                'users.name as user_name',
                'tbl_session.titel as session_title'
            )
            ->orderBy('tbl_session_progress.created_at', 'desc')
            ->get();

        return view('admin.session_uploads', compact('uploads'));
    }













}
