<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::with('category')->get();
            return response()->json([
                'message' => 'Daftar produk berhasil diambil',
                'data' => $products
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error saat mengambil daftar produk', [
                'message' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Terjadi kesalahan sistem'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['user_id'] = Auth::id();

            $product = Product::create($validated);

            Log::info('Menambah data produk', [
                'list' => $product
            ]);

            return response()->json([
                'message' => 'Produk berhasil ditambahkan!!',
                'data' => $product,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Error saat menambah product', [
                'message' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Terjadi kesalahan sistem'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $product = Product::with('category')->find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'message' => 'Product retrieved successfully',
                'data' => $product
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data produk', [
                'message' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Terjadi kesalahan sistem'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            // Gate policy checks can be implemented here if needed

            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'qty' => 'required|integer',
                'price' => 'required|numeric',
            ]);

            $product->update($validated);

            Log::info('Update data produk', ['id' => $product->id]);

            return response()->json([
                'message' => 'Produk berhasil diperbarui',
                'data' => $product
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Error saat mengubah product', [
                'message' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Terjadi kesalahan sistem'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            $product->delete();

            Log::info('Hapus data produk', ['id' => $id]);

            return response()->json([
                'message' => 'Produk berhasil dihapus'
            ], 200);

        } catch (\Throwable $e) {
            Log::error('Error saat menghapus product', [
                'message' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Terjadi kesalahan sistem'], 500);
        }
    }
}
