<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function dashboard()
    {
        $categories = Category::where('is_active', true)->withCount('products')->get();
        $products = Product::where('is_active', true)->with('category')->get();
        
        return view('kasir.dashboard', compact('categories', 'products'));
    }

    public function getProductsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)
            ->where('is_active', true)
            ->get();
        
        return response()->json($products);
    }

    public function processTransaction(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,card,qris,transfer',
            'paid' => 'required|numeric|min:0',
            'member_id' => 'nullable|exists:members,id',
        ]);

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $items = [];

            // Calculate subtotal and prepare items
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Check stock
                if ($product->stock < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stock {$product->name} tidak mencukupi!"
                    ], 400);
                }

                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $items[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $itemSubtotal
                ];
            }

            $tax = $subtotal * 0.1; // 10% tax
            $total = $subtotal + $tax;
            $change = $request->paid - $total;

            if ($change < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran tidak mencukupi!'
                ], 400);
            }

            // Create transaction
            $transaction = Transaction::create([
                'transaction_code' => 'TRX-' . date('Ymd') . '-' . str_pad(Transaction::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT),
                'user_id' => Auth::id(),
                'member_id' => $request->member_id,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'paid' => $request->paid,
                'change' => $change,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'notes' => $request->notes ?? null,
            ]);

            // Create transaction items and update stock
            foreach ($items as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'price' => $item['product']->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Update stock
                $item['product']->decrement('stock', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'transaction' => $transaction->load('items'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
