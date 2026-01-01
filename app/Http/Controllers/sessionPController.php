<?php

namespace App\Http\Controllers;

use App\Models\SessionProgress;
use Illuminate\Http\Request;

class SessionPController extends Controller
{
    // ===============================
    // SHOW ONLY SESSIONS WITH PDF
    // ===============================
    public function index()
    {
        $progress = SessionProgress::whereNotNull('pdf_file')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('session_progress.index', compact('progress'));
    }

    // ===============================
    // UPDATE ONLY pdf_status
    // ===============================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'pdf_status' => 'required|in:pending,approved,rejected'
        ]);

        $item = SessionProgress::findOrFail($id);

        // ONLY update this field
        $item->pdf_status = $request->pdf_status;
        $item->save();

        return redirect()->back()->with('success', 'Status updated successfully');
    }
}
