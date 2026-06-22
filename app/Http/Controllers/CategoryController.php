<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\ActivityLog;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::latest()->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $category = Category::create($request->validated());

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'CREATE_CATEGORY',
            'category' => 'system',
            'description' => 'Menambahkan kategori: ' . $category->name,
            'created_at' => now(),
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'UPDATE_CATEGORY',
            'category' => 'system',
            'description' => 'Mengubah kategori: ' . $category->name,
            'created_at' => now(),
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $categoryName = $category->name;
        $category->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'DELETE_CATEGORY',
            'category' => 'system',
            'description' => 'Menghapus kategori: ' . $categoryName,
            'created_at' => now(),
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
