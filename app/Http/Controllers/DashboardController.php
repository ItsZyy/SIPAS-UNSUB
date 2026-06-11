<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalArchives = Archive::count();
        $totalCategories = Category::count();
        $archivesThisMonth = Archive::whereMonth('document_date', now()->month)
            ->whereYear('document_date', now()->year)
            ->count();
        $archivesThisYear = Archive::whereYear('document_date', now()->year)->count();

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
