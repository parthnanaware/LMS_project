<?php

namespace App\Http\Controllers;

use App\Models\SessionProgress;
use App\Models\tbl_session;
use Illuminate\Http\Request;

class SessionPController extends Controller
{

    public function index()
    {
        $progress = SessionProgress::whereNotNull('pdf_file')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('session_progress.index', compact('progress'));
    }


public function updateStatus(Request $request, $id)
{
    // 1️⃣ Get progress row
    $item = SessionProgress::findOrFail($id);

    // 2️⃣ Approve PDF of CURRENT session
    $item->pdf_status = 'approved';
    $item->save();

    // 3️⃣ Unlock NEXT session (NOT same)
    $nextSession = tbl_session::where('section_id', $item->section_id)
        ->where('id', '>', $item->session_id)
        ->orderBy('id')
        ->first();

    if ($nextSession) {
        $nextSession->is_locked = 1;
        $nextSession->save();
    }

    return redirect()->back()
        ->with('success', 'PDF approved & next session unlocked');
}

    public function videoComplete(Request $request)
{
    $request->validate([
        'user_id'    => 'required|integer',
        'session_id' => 'required|integer',
    ]);

    SessionProgress::updateOrCreate(
        [
            'user_id'    => $request->user_id,
            'session_id' => $request->session_id,
        ],
        [
            'video_status' => 'approved',
            'pdf_status'   => 'pending',
        ]
    );

    return response()->json([
        'status'  => 'success',
        'message' => 'Video completed',
    ]);
}

}
