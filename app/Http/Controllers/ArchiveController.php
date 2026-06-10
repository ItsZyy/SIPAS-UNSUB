<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArchiveRequest;
use App\Models\Archive;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArchiveController extends Controller
{
    public function index(): View
    {
        $archives = Archive::with(['category', 'uploader'])->latest()->paginate(10);

        return view('archives.index', compact('archives'));
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
            $data['file_path'] = $request->file('file')->store('archives', 'public');
        }

        $data['uploaded_by'] = Auth::id();

        Archive::create($data);

        return redirect()->route('archives.index')
            ->with('success', 'Arsip berhasil ditambahkan.');
    }

    public function show(Archive $archive): View
    {
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
            if ($archive->file_path && Storage::disk('public')->exists($archive->file_path)) {
                Storage::disk('public')->delete($archive->file_path);
            }

            $data['file_path'] = $request->file('file')->store('archives', 'public');
        }

        $archive->update($data);

        return redirect()->route('archives.index')
            ->with('success', 'Arsip berhasil diperbarui.');
    }

    public function destroy(Archive $archive): RedirectResponse
    {
        if ($archive->file_path && Storage::disk('public')->exists($archive->file_path)) {
            Storage::disk('public')->delete($archive->file_path);
        }

        $archive->delete();

        return redirect()->route('archives.index')
            ->with('success', 'Arsip berhasil dihapus.');
    }
}
