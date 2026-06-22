<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArchiveRequest;
use App\Models\ActivityLog;
use App\Models\Archive;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArchiveController extends Controller
{
    public function index(): View
    {
        $categories = Category::all();

        $archives = Archive::with(['category', 'uploader'])
            ->when(request('search'), function ($query) {
                $query->where(function ($q) {
                    $q->where('document_number', 'like', '%' . request('search') . '%')
                      ->orWhere('title', 'like', '%' . request('search') . '%');
                });
            })
            ->when(request('category'), function ($query) {
                $query->where('category_id', request('category'));
            })
            ->when(request('year'), function ($query) {
                $query->whereYear('document_date', request('year'));
            })
            ->when(request('sort'), function ($query) {
                match (request('sort')) {
                    'oldest'    => $query->oldest(),
                    'title_asc' => $query->orderBy('title'),
                    'title_desc'=> $query->orderByDesc('title'),
                    default     => $query->latest(),
                };
            }, function ($query) {
                $query->latest();
            })
            ->paginate(10)
            ->withQueryString();

        return view('archives.index', compact('archives', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::all();

        return view('archives.create', compact('categories'));
    }

    public function store(ArchiveRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            try {
                $data['file_path'] = $request->file('file')->store('archives', 'public');
            } catch (\Exception $e) {
                Log::error('[UPLOAD] Gagal menyimpan file ke disk', [
                    'error' => $e->getMessage(),
                    'file' => $request->file('file')->getClientOriginalName(),
                    'size' => $request->file('file')->getSize(),
                ]);
                return redirect()->back()->withInput()->with('error',
                    'Gagal menyimpan file ke server. Penyebab: ' . $e->getMessage()
                );
            }
        }

        $data['uploaded_by'] = Auth::id();

        $archive = Archive::create($data);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'UPLOAD',
            'category' => 'system',
            'description' => 'Mengunggah surat: ' . $archive->file_name,
            'archive_id' => $archive->id,
            'archive_title' => $archive->title,
            'archive_number' => $archive->document_number,
            'created_at' => now(),
        ]);

        return redirect()->route('archives.index')
            ->with('success', 'Arsip berhasil ditambahkan.');
    }

    public function show(Archive $archive): View
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'VIEW',
            'category' => 'activity',
            'description' => 'Melihat surat: ' . $archive->file_name,
            'archive_id' => $archive->id,
            'archive_title' => $archive->title,
            'archive_number' => $archive->document_number,
            'created_at' => now(),
        ]);

        return view('archives.show', compact('archive'));
    }

    public function edit(Archive $archive): View
    {
        $categories = Category::all();

        return view('archives.edit', compact('archive', 'categories'));
    }

    public function update(ArchiveRequest $request, Archive $archive): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            try {
                if ($archive->file_path && Storage::disk('public')->exists($archive->file_path)) {
                    Storage::disk('public')->delete($archive->file_path);
                }

                $data['file_path'] = $request->file('file')->store('archives', 'public');
            } catch (\Exception $e) {
                Log::error('[UPLOAD] Gagal menyimpan file ke disk saat update', [
                    'error' => $e->getMessage(),
                    'file' => $request->file('file')->getClientOriginalName(),
                    'size' => $request->file('file')->getSize(),
                ]);
                return redirect()->back()->withInput()->with('error',
                    'Gagal menyimpan file ke server. Penyebab: ' . $e->getMessage()
                );
            }
        }

        $archive->update($data);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'EDIT',
            'category' => 'system',
            'description' => 'Mengubah data surat: ' . $archive->file_name,
            'archive_id' => $archive->id,
            'archive_title' => $archive->title,
            'archive_number' => $archive->document_number,
            'created_at' => now(),
        ]);

        return redirect()->route('archives.index')
            ->with('success', 'Arsip berhasil diperbarui.');
    }

    public function destroy(Archive $archive): RedirectResponse
    {
        $fileName = $archive->file_name;

        if ($archive->file_path && Storage::disk('public')->exists($archive->file_path)) {
            Storage::disk('public')->delete($archive->file_path);
        }

        $archive->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'DELETE',
            'category' => 'system',
            'description' => 'Menghapus surat: ' . $fileName,
            'archive_title' => $archive->title,
            'archive_number' => $archive->document_number,
            'created_at' => now(),
        ]);

        return redirect()->route('archives.index')
            ->with('success', 'Arsip berhasil dihapus.');
    }

    public function download(Archive $archive): mixed
    {
        if (!$archive->file_path || !Storage::disk('public')->exists($archive->file_path)) {
            return redirect()->route('archives.show', $archive)
                ->with('error', 'File tidak ditemukan.');
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'DOWNLOAD',
            'category' => 'activity',
            'description' => 'Mengunduh surat: ' . $archive->file_name,
            'archive_id' => $archive->id,
            'archive_title' => $archive->title,
            'archive_number' => $archive->document_number,
            'created_at' => now(),
        ]);

        return Storage::disk('public')->download($archive->file_path);
    }
}
