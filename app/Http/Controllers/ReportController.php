<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\View\View; 
use Illuminate\Http\RedirectResponse; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;   
use App\Models\Report; 

class ReportController extends Controller
{
    public function index(): View
    {
        $reports = Report::with('user')
                     ->whereNotNull(['latitude', 'longitude']) 
                     ->latest()
                     ->paginate(6); 


                     return view('reports.index', compact('reports'));
    }

    public function create(): View 
    {
        return view('reports.bikinlapor');
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'required|string',
            'location_text' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('reports_images', $imageName, 'public');
        } else {
            return back()->withErrors(['image' => 'Upload gambar gagal atau file tidak valid.'])->withInput();
        }

        Report::create([
            'user_id' => Auth::id(),
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'location_text' => $validatedData['location_text'],
            'image_path' => $imagePath,
            'status' => 'dilaporkan',
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan kerusakan berhasil dikirim!');
    }

    public function show(Report $report): View
    {
        $report->load(['user', 'comments.user']);

        return view('reports.show', compact('report'));
    }
}
