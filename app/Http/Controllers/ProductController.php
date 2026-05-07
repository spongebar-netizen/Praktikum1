<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('product.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'qty' => 'required|integer',
            'price' => 'required|numeric',
        ], [
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.exists' => 'Kategori produk tidak valid.',
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
            'qty.required' => 'Jumlah (kuantitas) produk wajib diisi.',
            'qty.integer' => 'Jumlah produk harus berupa angka bulat (tidak boleh desimal).',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga produk harus berupa angka yang valid.',
        ]);

        $validated['user_id'] = Auth::id();

        try {
            Product::create($validated);
            return redirect()
                ->route('product.index')
                ->with('success', 'Product created successfully.');
        } catch (QueryException $e) {
            Log::error('Product store database error', [
                'message' => $e->getMessage(),
            ]);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error while creating product.');
        } catch (\Throwable $e) {
            Log::error('Product store unexpected error', [
                'message' => $e->getMessage(),
            ]);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Unexpected error occurred.');
        }
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('product.create', compact('users', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('product.view', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('update', $product);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'qty' => 'required|integer',
            'price' => 'required|numeric',
        ], [
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.exists' => 'Kategori produk tidak valid.',
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
            'qty.required' => 'Jumlah (kuantitas) produk wajib diisi.',
            'qty.integer' => 'Jumlah produk harus berupa angka bulat (tidak boleh desimal).',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga produk harus berupa angka yang valid.',
        ]);

        try {
            $product->update($validated);
            return redirect()
                ->route('product.index')
                ->with('success', 'Product updated successfully.');
        } catch (QueryException $e) {
            Log::error('Product update database error', [
                'message' => $e->getMessage(),
            ]);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error while updating product.');
        } catch (\Throwable $e) {
            Log::error('Product update unexpected error', [
                'message' => $e->getMessage(),
            ]);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Unexpected error occurred.');
        }
    }

    public function edit(Product $product)
    {
        Gate::authorize('update', $product);
        $users = User::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('product.edit', compact('product', 'users', 'categories'));
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('delete', $product);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}
