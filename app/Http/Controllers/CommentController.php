<?php

namespace App\Http\Controllers;

use App\Models\Report; 
use App\Models\Comment; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Report $report): RedirectResponse
    {
        $validated = $request->validate([
            'body' => 'required|string|min:3|max:1000', 
        ]);

        $report->comments()->create([
            'user_id' => Auth::id(),
            'body' => $validated['body'],
        ]);

        /* Alternatif jika tidak menggunakan relasi langsung:
        Comment::create([
            'report_id' => $report->id,
            'user_id' => Auth::id(),
            'body' => $validated['body'],
        ]);
        */

        return redirect()->route('laporan.show', $report->id)
                         ->with('success_comment', 'Komentar berhasil ditambahkan!');
    }
}