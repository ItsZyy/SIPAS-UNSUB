<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArchiveRequest;
use App\Models\Archive;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
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
        Archive::create($request->validated() + ['uploaded_by' => Auth::id()]);

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
        $archive->update($request->validated());

        return redirect()->route('archives.index')
            ->with('success', 'Arsip berhasil diperbarui.');
    }

    public function destroy(Archive $archive): RedirectResponse
    {
        $archive->delete();

        return redirect()->route('archives.index')
            ->with('success', 'Arsip berhasil dihapus.');
    }
}
