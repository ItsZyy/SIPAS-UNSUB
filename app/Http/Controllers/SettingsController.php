<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsUpdateRequest;
use App\Models\ActivityLog;
use App\Models\SystemSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        return view('settings.index');
    }

    public function profile(Request $request): View
    {
        return view('settings.profile', [
            'user' => $request->user(),
        ]);
    }

    public function updateProfile(SettingsUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'PROFILE',
            'category' => 'activity',
            'description' => 'Memperbarui profil akun',
            'created_at' => now(),
        ]);

        return redirect()->route('settings.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function security(): View
    {
        return view('settings.security');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'PASSWORD',
            'category' => 'activity',
            'description' => 'Mengubah password akun',
            'created_at' => now(),
        ]);

        return redirect()->route('settings.security')
            ->with('success', 'Password berhasil diperbarui.');
    }

    public function theme(Request $request): View
    {
        return view('settings.theme', [
            'user' => $request->user(),
        ]);
    }

    public function updateTheme(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'theme' => ['required', 'in:system,light,dark'],
        ]);

        $request->user()->update([
            'theme' => $validated['theme'],
        ]);

        return redirect()->route('settings.theme')
            ->with('success', 'Tema berhasil diperbarui.');
    }

    public function toggleTheme(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'theme' => ['required', 'in:light,dark'],
        ]);

        $request->user()->update([
            'theme' => $validated['theme'],
        ]);

        return response()->json(['success' => true]);
    }

    public function system(): View
    {
        return view('settings.system', [
            'sessionTimeout' => SystemSetting::getValue('session_timeout', '30'),
            'maxFileSize' => SystemSetting::getValue('max_file_size', '25'),
            'logRetentionDays' => SystemSetting::getValue('log_retention_days', '30'),
        ]);
    }

    public function updateSystemSettings(Request $request): RedirectResponse
    {
        $sessionTimeout = $request->input('session_timeout') ?: $request->input('session_timeout_custom');
        $maxFileSize = $request->input('max_file_size') ?: $request->input('max_file_size_custom');
        $logRetentionDays = $request->input('log_retention_days') ?: $request->input('log_retention_days_custom');

        $validated = validator(compact('sessionTimeout', 'maxFileSize', 'logRetentionDays'), [
            'sessionTimeout' => ['required', 'integer', 'min:1', 'max:480'],
            'maxFileSize' => ['required', 'integer', 'min:1', 'max:500'],
            'logRetentionDays' => ['required', 'integer', 'min:1', 'max:3650'],
        ])->validate();

        SystemSetting::setValue('session_timeout', $validated['sessionTimeout']);
        SystemSetting::setValue('max_file_size', $validated['maxFileSize']);
        SystemSetting::setValue('log_retention_days', $validated['logRetentionDays']);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'SETTINGS',
            'category' => 'system',
            'description' => 'Memperbarui konfigurasi sistem: Session Timeout=' . $validated['sessionTimeout'] . ' menit, Max File Size=' . $validated['maxFileSize'] . ' MB, Retensi Log=' . $validated['logRetentionDays'] . ' hari',
            'created_at' => now(),
        ]);

        return redirect()->route('settings.system')
            ->with('success', 'Konfigurasi sistem berhasil diperbarui.');
    }

    public function keepAlive(): JsonResponse
    {
        return response()->json(['success' => true]);
    }

    public function autoLogout(Request $request): JsonResponse
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'LOGOUT',
            'category' => 'activity',
            'description' => 'Logout otomatis karena session timeout',
            'created_at' => now(),
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'redirect' => url('/login'),
        ]);
    }
}
