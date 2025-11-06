@extends('layouts.user')

@section('title', 'User Dashboard - POS Kasir')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="space-y-6">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-8 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="text-purple-100">
                        @if($member)
                            Member {{ $member->member_code }} • {{ $member->rating_stars }}
                        @else
                            Register sebagai member untuk mendapatkan benefit lebih!
                        @endif
                    </p>
                </div>
                @if($member)
                <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                        <p class="text-sm text-purple-100 mb-1">Member Points</p>
                        <p class="text-3xl font-bold">{{ number_format($member->points, 1) }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        @if(!$member)
        <!-- Not a Member Alert -->
        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-lg">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-amber-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <h3 class="font-semibold text-amber-800 mb-1">Belum Terdaftar Sebagai Member</h3>
                    <p class="text-sm text-amber-700">
                        Email Anda ({{ Auth::user()->email }}) belum terdaftar sebagai member. 
                        Kunjungi kasir kami untuk mendaftar dan dapatkan benefit member seperti poin reward, diskon, dan tracking transaksi!
                    </p>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Stats -->
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Total Transactions</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $totalTransactions }}</h3>
                        @if($member)
                            <p class="text-xs text-gray-500 mt-1">{{ $member->rating_stars }}</p>
                        @endif
                    </div>
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Total Spent</p>
                        <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h3>
                        @if($member && $member->points > 0)
                            <p class="text-xs text-green-600 mt-1">+{{ number_format($member->points, 1) }} points</p>
                        @endif
                    </div>
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">
                            @if($member)
                                Member Since
                            @else
                                Registered
                            @endif
                        </p>
                        <h3 class="text-xl font-bold text-gray-800">
                            @if($member)
                                {{ $member->created_at->format('M Y') }}
                            @else
                                {{ Auth::user()->created_at->format('M Y') }}
                            @endif
                        </h3>
                        @if($member)
                            <p class="text-xs text-gray-500 mt-1">Rating: {{ $member->rating }}★</p>
                        @endif
                    </div>
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Transactions -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800">Recent Transactions</h3>
                <a href="{{ route('user.transactions') }}" class="text-purple-500 hover:text-purple-600 font-medium flex items-center">
                    View All
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            
            @if($recentTransactions->count() > 0)
                <div class="space-y-4">
                    @foreach($recentTransactions as $transaction)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer" onclick="showTransactionDetail({{ $transaction->id }})">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $transaction->transaction_code }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $transaction->created_at->format('d M Y, H:i') }} • 
                                    {{ $transaction->items->count() }} items • 
                                    {{ ucfirst($transaction->payment_method) }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
                            <span class="text-sm px-2 py-1 bg-green-100 text-green-700 rounded">{{ ucfirst($transaction->status) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p class="text-gray-500">
                        @if($member)
                            Belum ada transaksi
                        @else
                            Daftar sebagai member untuk melihat riwayat transaksi
                        @endif
                    </p>
                </div>
            @endif
        </div>
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
