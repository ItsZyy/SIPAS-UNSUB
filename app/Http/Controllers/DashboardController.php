<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Category;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalArchives = Archive::count();
        $totalCategories = Category::count();

        $archivesThisMonth = Archive::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $archivesThisYear = Archive::whereYear('created_at', now()->year)->count();

        $recentArchives = Archive::with(['category', 'uploader'])
            ->latest()
            ->take(5)
            ->get();

        $archivesPerCategory = Category::withCount('archives')
            ->orderByDesc('archives_count')
            ->get();

        return view('dashboard', compact(
            'totalArchives',
            'totalCategories',
            'archivesThisMonth',
            'archivesThisYear',
            'recentArchives',
            'archivesPerCategory'
        ));
    }
}
