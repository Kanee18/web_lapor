<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; 

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers = User::count();
        $totalReports = Report::count();
        $dilaporkanCount = Report::where('status', 'dilaporkan')->count();
        $diprosesCount = Report::where('status', 'diproses')->count();
        $selesaiCount = Report::where('status', 'selesai')->count();

        $recentPendingReports = Report::with('user')
                                    ->where('status', 'dilaporkan')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalReports',
            'dilaporkanCount',
            'diprosesCount',
            'selesaiCount',
            'recentPendingReports'
        ));
    }
}