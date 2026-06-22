<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(): View
    {
        $logs = ActivityLog::with('user')
            ->where('category', 'activity')
            ->when(request('search'), function ($query) {
                $query->where(function ($q) {
                    $q->where('activity', 'like', '%' . request('search') . '%')
                      ->orWhere('description', 'like', '%' . request('search') . '%')
                      ->orWhereHas('user', function ($userQuery) {
                          $userQuery->where('name', 'like', '%' . request('search') . '%');
                      });
                });
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('activity-logs.index', compact('logs'));
    }

    public function systemIndex(): View
    {
        $logs = ActivityLog::with('user')
            ->where('category', 'system')
            ->when(request('search'), function ($query) {
                $query->where(function ($q) {
                    $q->where('activity', 'like', '%' . request('search') . '%')
                      ->orWhere('description', 'like', '%' . request('search') . '%')
                      ->orWhereHas('user', function ($userQuery) {
                          $userQuery->where('name', 'like', '%' . request('search') . '%');
                      });
                });
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('system-logs.index', compact('logs'));
    }

    public function destroy(ActivityLog $activityLog): RedirectResponse
    {
        $activityLog->delete();

        return redirect()->route('activity-logs.index')
            ->with('success', 'Log aktivitas berhasil dihapus.');
    }

    public function destroySelected(Request $request): RedirectResponse
    {
        $ids = array_map('intval', (array) $request->input('selected_ids', []));

        $deleted = ActivityLog::whereIn('id', $ids)->delete();

        $message = $deleted > 0
            ? $deleted . ' log aktivitas berhasil dihapus.'
            : 'Tidak ada log aktivitas yang dihapus.';

        return redirect()->route('activity-logs.index')
            ->with($deleted > 0 ? 'success' : 'error', $message);
    }

    public function destroyAll(): RedirectResponse
    {
        $count = ActivityLog::where('category', 'activity')->count();

        ActivityLog::where('category', 'activity')->delete();

        $message = $count > 0
            ? 'Seluruh log aktivitas berhasil dihapus.'
            : 'Tidak ada log aktivitas untuk dihapus.';

        return redirect()->route('activity-logs.index')
            ->with($count > 0 ? 'success' : 'error', $message);
    }

    public function systemDestroy(ActivityLog $activityLog): RedirectResponse
    {
        $activityLog->delete();

        return redirect()->route('system-logs.index')
            ->with('success', 'Log sistem berhasil dihapus.');
    }

    public function systemDestroySelected(Request $request): RedirectResponse
    {
        $ids = array_map('intval', (array) $request->input('selected_ids', []));

        $deleted = ActivityLog::whereIn('id', $ids)->delete();

        $message = $deleted > 0
            ? $deleted . ' log sistem berhasil dihapus.'
            : 'Tidak ada log sistem yang dihapus.';

        return redirect()->route('system-logs.index')
            ->with($deleted > 0 ? 'success' : 'error', $message);
    }

    public function systemDestroyAll(): RedirectResponse
    {
        $count = ActivityLog::where('category', 'system')->count();

        ActivityLog::where('category', 'system')->delete();

        $message = $count > 0
            ? 'Seluruh log sistem berhasil dihapus.'
            : 'Tidak ada log sistem untuk dihapus.';

        return redirect()->route('system-logs.index')
            ->with($count > 0 ? 'success' : 'error', $message);
    }
}
