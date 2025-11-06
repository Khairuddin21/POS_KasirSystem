<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\TransactionItem;

class UserController extends Controller
{
    /**
     * Display user dashboard with member integration
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Find member by email
        $member = Member::where('email', $user->email)->first();
        
        // Get transactions if member exists
        $totalTransactions = 0;
        $totalSpent = 0;
        $recentTransactions = collect([]);
        
        if ($member) {
            $totalTransactions = Transaction::where('member_id', $member->id)->count();
            $totalSpent = $member->total_spent;
            
            // Get recent transactions (last 5)
            $recentTransactions = Transaction::where('member_id', $member->id)
                ->with(['items.product', 'user'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }
        
        return view('user.dashboard', compact(
            'user',
            'member',
            'totalTransactions',
            'totalSpent',
            'recentTransactions'
        ));
    }
    
    /**
     * Display all user transactions
     */
    public function transactions(Request $request)
    {
        $user = Auth::user();
        
        // Find member by email
        $member = Member::where('email', $user->email)->first();
        
        if (!$member) {
            return view('user.transactions', [
                'user' => $user,
                'member' => null,
                'transactions' => collect([])
            ]);
        }
        
        // Get all transactions with filters
        $query = Transaction::where('member_id', $member->id)
            ->with(['items.product', 'user']);
        
        // Date filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Payment method filter
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }
        
        // Sort
        $transactions = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('user.transactions', compact('user', 'member', 'transactions'));
    }
    
    /**
     * Get transaction detail
     */
    public function transactionDetail($id)
    {
        $user = Auth::user();
        $member = Member::where('email', $user->email)->first();
        
        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ], 404);
        }
        
        $transaction = Transaction::where('member_id', $member->id)
            ->where('id', $id)
            ->with(['items.product', 'user'])
            ->first();
        
        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ]);
    }
}
