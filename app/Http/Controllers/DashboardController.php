<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Category;
use Carbon\Carbon;
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

        // Card 1: Total Surat - kontribusi hari ini terhadap total sebelumnya
        $todayArchives = Archive::whereDate('created_at', today())->count();
        $totalBeforeToday = Archive::whereDate('created_at', '<', today())->count();
        $card1Growth = $this->calculateProportion($todayArchives, $totalBeforeToday);

        // Card 2: Total Kategori - jumlah kategori baru hari ini
        $categoriesToday = Category::whereDate('created_at', today())->count();
        if ($categoriesToday > 0) {
            $card2Growth = ['value' => $categoriesToday, 'direction' => 'up'];
        } else {
            $card2Growth = ['value' => 0, 'direction' => 'neutral'];
        }

        // Card 3: Arsip Bulan Ini - kontribusi hari ini terhadap 1 sd kemarin di bulan yg sama
        $archivesThisMonthBeforeToday = Archive::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->whereDate('created_at', '<', today())
            ->count();
        $card3Growth = $this->calculateProportion($todayArchives, $archivesThisMonthBeforeToday);

        // Card 4: Arsip Tahun Ini - kontribusi periode berjalan terhadap tahun berjalan
        $archivesThisYearBeforeThisMonth = Archive::whereYear('created_at', now()->year)
            ->whereMonth('created_at', '<', now()->month)
            ->count();
        if ($archivesThisYearBeforeThisMonth > 0) {
            $card4Growth = $this->calculateProportion($archivesThisMonth, $archivesThisYearBeforeThisMonth);
        } else {
            $archivesThisYearBeforeToday = Archive::whereYear('created_at', now()->year)
                ->whereDate('created_at', '<', today())
                ->count();
            $card4Growth = $this->calculateProportion($todayArchives, $archivesThisYearBeforeToday);
        }

        // Weekly chart
        Carbon::setLocale('id');

        $weeklyArchives = Archive::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $weeklyLabels = collect();
        $weeklyData = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i)->toDateString();
            $weeklyLabels->push(today()->subDays($i)->isoFormat('dddd'));
            $weeklyData->push($weeklyArchives->get($date, 0));
        }

        return view('dashboard', compact(
            'totalArchives',
            'totalCategories',
            'archivesThisMonth',
            'archivesThisYear',
            'recentArchives',
            'archivesPerCategory',
            'card1Growth',
            'card2Growth',
            'card3Growth',
            'card4Growth',
            'weeklyLabels',
            'weeklyData'
        ));
    }

    private function calculateProportion(int $current, int $previous): array
    {
        if ($previous === 0) {
            return ['percentage' => 0, 'direction' => 'neutral'];
        }

        $percentage = round(($current / $previous) * 100, 1);

        if ($percentage > 0) {
            return ['percentage' => $percentage, 'direction' => 'up'];
        }

        return ['percentage' => 0, 'direction' => 'neutral'];
    }
}
