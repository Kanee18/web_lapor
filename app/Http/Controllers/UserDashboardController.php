<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report; 
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $reports = Report::where('user_id', $user->id);

        $totalUserReports = (clone $reports)->count();
        $dilaporkanCount = (clone $reports)->where('status', 'dilaporkan')->count();
        $diprosesCount = (clone $reports)->where('status', 'diproses')->count();
        $selesaiCount = (clone $reports)->where('status', 'selesai')->count();

        // Ambil 3 laporan terbaru pengguna
        $latestUserReports = Report::where('user_id', $user->id)
                                  ->latest()
                                  ->take(3)
                                  ->get();

        return view('dashboard', compact(
            'user',
            'totalUserReports',
            'dilaporkanCount',
            'diprosesCount',
            'selesaiCount',
            'latestUserReports'
        ));
    }
}