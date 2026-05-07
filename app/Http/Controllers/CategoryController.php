<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        // Load categories with count of their products
        $categories = Category::withCount('products')->get();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ], [
            'name.required' => 'Nama Kategori wajib diisi.',
            'name.unique' => 'Nama Kategori sudah ada, silakan gunakan nama lain.'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id
        ], [
            'name.required' => 'Nama Kategori wajib diisi.',
            'name.unique' => 'Nama Kategori sudah ada, silakan gunakan nama lain.'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
