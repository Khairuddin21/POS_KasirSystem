@extends('layouts.user')

@section('title', 'Transaction History - POS Kasir')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Transaction History</h1>
                <p class="text-gray-600 mt-1">Riwayat lengkap pembelanjaan Anda</p>
            </div>
            <a href="{{ route('user.dashboard') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>

        @if(!$member)
        <!-- Not a Member Alert -->
        <div class="bg-amber-50 border-l-4 border-amber-500 p-6 rounded-lg">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-amber-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <h3 class="font-semibold text-amber-800 mb-1">Belum Terdaftar Sebagai Member</h3>
                    <p class="text-sm text-amber-700">
                        Email Anda ({{ $user->email }}) belum terdaftar sebagai member. 
                        Kunjungi kasir kami untuk mendaftar dan mulai tracking transaksi Anda!
                    </p>
                </div>
            </div>
        </div>
        @else
        <!-- Member Info Card -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="grid md:grid-cols-4 gap-4">
                <div>
                    <p class="text-purple-100 text-sm mb-1">Member Code</p>
                    <p class="text-xl font-bold">{{ $member->member_code }}</p>
                </div>
                <div>
                    <p class="text-purple-100 text-sm mb-1">Member Rating</p>
                    <p class="text-xl font-bold">{{ $member->rating_stars }}</p>
                </div>
                <div>
                    <p class="text-purple-100 text-sm mb-1">Total Points</p>
                    <p class="text-xl font-bold">{{ number_format($member->points, 1) }}</p>
                </div>
                <div>
                    <p class="text-purple-100 text-sm mb-1">Total Spent</p>
                    <p class="text-xl font-bold">Rp {{ number_format($member->total_spent, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filter Transactions
            </h2>
            <form action="{{ route('user.transactions') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                    <select name="payment_method" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Methods</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>
                <div class="md:col-span-3 flex justify-end space-x-3">
                    <a href="{{ route('user.transactions') }}" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition">
                        Reset Filter
                    </a>
                    <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition">
                        Apply Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Transactions List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($transactions && $transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Transaction Code</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Date & Time</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Items</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Payment</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Total</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($transactions as $transaction)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-800">{{ $transaction->transaction_code }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">
                                    {{ $transaction->created_at->format('d M Y') }}<br>
                                    <span class="text-gray-500">{{ $transaction->created_at->format('H:i') }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">
                                    {{ $transaction->items->count() }} items
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                        {{ $transaction->payment_method == 'cash' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($transaction->payment_method) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-700">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button onclick="showTransactionDetail({{ $transaction->id }})" 
                                        class="text-purple-600 hover:text-purple-800 font-medium">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">No transactions found</p>
                    <p class="text-gray-400 text-sm mt-2">Try adjusting your filters or make a purchase</p>
                </div>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Transaction Detail Modal -->
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-t-2xl">
            <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold">Transaction Detail</h3>
                <button onclick="closeDetailModal()" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <div id="detailContent" class="p-6">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function showTransactionDetail(transactionId) {
    fetch(`/user/transactions/${transactionId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const transaction = data.transaction;
                let itemsHtml = '';
                
                transaction.items.forEach((item, index) => {
                    itemsHtml += `
                        <div class="flex items-center justify-between py-3 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-semibold">
                                    ${index + 1}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">${item.product.name}</p>
                                    <p class="text-sm text-gray-500">${item.quantity} × Rp ${Number(item.price).toLocaleString('id-ID')}</p>
                                </div>
                            </div>
                            <p class="font-semibold text-gray-800">Rp ${Number(item.subtotal).toLocaleString('id-ID')}</p>
                        </div>
                    `;
                });
                
                document.getElementById('detailContent').innerHTML = `
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Transaction Code</p>
                                <p class="font-semibold text-gray-800">${transaction.transaction_code}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Date</p>
                                <p class="font-semibold text-gray-800">${new Date(transaction.created_at).toLocaleString('id-ID')}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Payment Method</p>
                                <p class="font-semibold text-gray-800 capitalize">${transaction.payment_method}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Cashier</p>
                                <p class="font-semibold text-gray-800">${transaction.user.name}</p>
                            </div>
                        </div>
                        
                        <div class="border-t pt-4">
                            <h4 class="font-semibold text-gray-800 mb-3">Items Purchased</h4>
                            <div class="space-y-2">
                                ${itemsHtml}
                            </div>
                        </div>
                        
                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>Rp ${Number(transaction.subtotal).toLocaleString('id-ID')}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Tax (11%)</span>
                                <span>Rp ${Number(transaction.tax).toLocaleString('id-ID')}</span>
                            </div>
                            <div class="flex justify-between text-xl font-bold text-gray-800 pt-2 border-t">
                                <span>Total</span>
                                <span>Rp ${Number(transaction.total).toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                    </div>
                `;
                
                document.getElementById('detailModal').classList.remove('hidden');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load transaction details'
            });
        });
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

// Close modal on outside click
document.getElementById('detailModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDetailModal();
    }
});
</script>
@endsection
