<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SessionProgress;

class SessionProgressController extends Controller
{
    public function index()
    {
        $progress = SessionProgress::orderBy('created_at', 'desc')->get();
        return view('admin.session_progress.index', compact('progress'));
    }

    public function approvePdf($id)
    {
        $item = SessionProgress::findOrFail($id);
        $item->pdf_status = 'approved';
        $item->save();

        return redirect()->back()->with('success', 'PDF approved successfully');
    }

    public function rejectPdf($id)
    {
        $item = SessionProgress::findOrFail($id);
        $item->pdf_status = 'locked';
        $item->pdf_file = null;
        $item->save();

        return redirect()->back()->with('success', 'PDF rejected successfully');
    }
}
