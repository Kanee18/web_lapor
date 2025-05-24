<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; 

class ReportController extends Controller
{
    /**
     * Display a listing of all reports for the admin.
     */
    public function index(): View
    {
        $reports = Report::with('user')
                           ->latest()
                           ->paginate(15);

        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Update the status of the specified report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Report $report): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:dilaporkan,diproses,selesai',
        ]);

        // 2. Update status laporan
        $report->status = $validated['status'];
        $report->save();

        return redirect()->route('admin.reports.index')
                         ->with('success_status_update', 'Status laporan berhasil diperbarui!');
    }
}