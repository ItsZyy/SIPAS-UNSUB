<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'CREATE_USER',
            'category' => 'system',
            'description' => 'Menambahkan pengguna: ' . $user->name . ' (' . $user->email . ')',
            'created_at' => now(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'UPDATE_USER',
            'category' => 'system',
            'description' => 'Mengubah data pengguna: ' . $user->name . ' (' . $user->email . ')',
            'created_at' => now(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function editPassword(User $user): View
    {
        return view('users.reset-password', compact('user'));
    }

    public function updatePassword(ResetPasswordRequest $request, User $user): RedirectResponse
    {
        $user->update([
            'password' => $request->password,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'RESET_PASSWORD',
            'category' => 'system',
            'description' => 'Mereset password pengguna: ' . $user->name . ' (' . $user->email . ')',
            'created_at' => now(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Password pengguna berhasil direset.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('users.index')
                ->with('error', 'Tidak dapat menghapus admin terakhir.');
        }

        $user->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'DELETE_USER',
            'category' => 'system',
            'description' => 'Menghapus pengguna: ' . $user->name . ' (' . $user->email . ')',
            'created_at' => now(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
