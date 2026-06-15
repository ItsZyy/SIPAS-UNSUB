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

    public function destroy(ActivityLog $activityLog): RedirectResponse
    {
        $activityLog->delete();

        return redirect()->route('activity-logs.index')
            ->with('success', 'Log aktivitas berhasil dihapus.');
    }

    public function destroySelected(Request $request): RedirectResponse
    {
        $ids = array_map('intval', (array) $request->input('selected_ids', []));

        Log::debug('[ActivityLog] destroySelected - Raw input:', $request->all());
        Log::debug('[ActivityLog] destroySelected - Cast IDs:', $ids);
        Log::debug('[ActivityLog] destroySelected - Type:', ['type' => gettype($ids)]);

        $query = ActivityLog::whereIn('id', $ids);
        Log::debug('[ActivityLog] destroySelected - SQL:', [$query->toSql()]);
        Log::debug('[ActivityLog] destroySelected - Bindings:', $query->getBindings());

        $deleted = $query->delete();

        Log::debug('[ActivityLog] destroySelected - Deleted count:', ['count' => $deleted]);

        $message = $deleted > 0
            ? $deleted . ' log aktivitas berhasil dihapus.'
            : 'Tidak ada log aktivitas yang dihapus.';

        return redirect()->route('activity-logs.index')
            ->with($deleted > 0 ? 'success' : 'error', $message);
    }

    public function destroyAll(): RedirectResponse
    {
        $count = ActivityLog::count();

        Log::debug('[ActivityLog] destroyAll - Total records before delete:', ['count' => $count]);

        ActivityLog::query()->delete();

        $afterCount = ActivityLog::count();
        Log::debug('[ActivityLog] destroyAll - Records after delete:', ['count' => $afterCount]);

        $message = $count > 0
            ? 'Seluruh log aktivitas berhasil dihapus.'
            : 'Tidak ada log aktivitas untuk dihapus.';

        return redirect()->route('activity-logs.index')
            ->with($count > 0 ? 'success' : 'error', $message);
    }
}
