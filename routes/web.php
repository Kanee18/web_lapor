<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
Route::get('/laporan/{report}', [ReportController::class, 'show'])->name('laporan.show');

Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])->name('chatbot.ask');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/laporan-buat', [ReportController::class, 'create'])->name('laporan.bikinlapor');
    Route::get('/laporan/buat', [ReportController::class, 'create'])->name('laporan.create'); 
    Route::post('/laporan', [ReportController::class, 'store'])->name('laporan.store');       
    Route::post('/laporan/{report}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard'); 
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index'); 
    Route::patch('/reports/{report}/status', [AdminReportController::class, 'updateStatus'])->name('reports.updateStatus'); 
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

require __DIR__.'/auth.php';
