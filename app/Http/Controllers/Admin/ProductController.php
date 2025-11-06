<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->get();
        
        $query = Product::with('category');
        
        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by category
        if ($request->has('category') && $request->category != '' && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status === 'active');
        }
        
        $products = $query->orderBy('created_at', 'desc')->get();
        
        // Statistics
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $lowStock = Product::where('stock', '<', 10)->where('is_active', true)->count();
        $totalValue = Product::where('is_active', true)->sum(DB::raw('price * stock'));
        
        return view('admin.products.index', compact(
            'products',
            'categories',
            'totalProducts',
            'activeProducts',
            'lowStock',
            'totalValue'
        ));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            // Only get validated data to avoid unwanted fields
            $data = $request->only([
                'category_id',
                'name',
                'description',
                'price',
                'stock',
                'sku'
            ]);
            
            $data['slug'] = Str::slug($request->name . '-' . Str::random(5));
            $data['is_active'] = $request->input('is_active', 0) == 1 ? true : false;
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $imageName);
                $data['image'] = 'images/products/' . $imageName;
            }
            
            $product = Product::create($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan!',
                'product' => $product->load('category')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan produk: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function show($id)
    {
        try {
            $product = Product::with('category')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'sku' => 'required|string|unique:products,sku,' . $id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'boolean'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal!',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            // Only get validated data to avoid _method and other unwanted fields
            $data = $request->only([
                'category_id',
                'name',
                'description',
                'price',
                'stock',
                'sku'
            ]);
            
            $data['slug'] = Str::slug($request->name . '-' . Str::random(5));
            $data['is_active'] = $request->input('is_active', 0) == 1 ? true : false;
            
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($product->image && file_exists(public_path($product->image))) {
                    unlink(public_path($product->image));
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $imageName);
                $data['image'] = 'images/products/' . $imageName;
            }
            
            $product->update($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui!',
                'product' => $product->load('category')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui produk: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Delete image if exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            
            $product->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus produk: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function toggleStatus($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->is_active = !$product->is_active;
            $product->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Status produk berhasil diubah!',
                'is_active' => $product->is_active
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }
}
