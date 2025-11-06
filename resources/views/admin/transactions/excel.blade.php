<table>
    <thead>
        <tr>
            <th colspan="8" style="text-align: center; font-size: 16px; font-weight: bold;">LAPORAN TRANSAKSI PENJUALAN</th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center;">Periode: {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d M Y') }}</th>
        </tr>
        <tr><th colspan="8"></th></tr>
        <tr>
            <th colspan="2" style="font-weight: bold;">Total Transaksi:</th>
            <th>{{ number_format($statistics['totalTransactions']) }}</th>
            <th colspan="2" style="font-weight: bold;">Total Pendapatan:</th>
            <th colspan="3">Rp {{ number_format($statistics['totalRevenue'], 0, ',', '.') }}</th>
        </tr>
        <tr>
            <th colspan="2" style="font-weight: bold;">Total Items:</th>
            <th>{{ number_format($statistics['totalItems']) }}</th>
            <th colspan="2" style="font-weight: bold;">Rata-rata Transaksi:</th>
            <th colspan="3">Rp {{ number_format($statistics['avgTransaction'], 0, ',', '.') }}</th>
        </tr>
        <tr>
            <th colspan="2" style="font-weight: bold;">Cash Revenue:</th>
            <th>Rp {{ number_format($statistics['cashRevenue'], 0, ',', '.') }}</th>
            <th colspan="2" style="font-weight: bold;">QRIS Revenue:</th>
            <th colspan="3">Rp {{ number_format($statistics['qrisRevenue'], 0, ',', '.') }}</th>
        </tr>
        <tr><th colspan="8"></th></tr>
        <tr style="font-weight: bold; background-color: #06b6d4; color: white;">
            <th>No</th>
            <th>Invoice Number</th>
            <th>Tanggal</th>
            <th>Kasir</th>
            <th>Member</th>
            <th>Items</th>
            <th>Metode Pembayaran</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transactions as $index => $transaction)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $transaction->transaction_code }}</td>
                <td>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</td>
                <td>{{ $transaction->user->name ?? '-' }}</td>
                <td>{{ $transaction->member->name ?? 'Non Member' }}</td>
                <td>{{ $transaction->items->sum('quantity') }}</td>
                <td>{{ strtoupper($transaction->payment_method) }}</td>
                <td>{{ number_format($transaction->total, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" style="text-align: center;">Tidak ada data transaksi</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr style="font-weight: bold; background-color: #e0f7fa;">
            <td colspan="7" style="text-align: right;">TOTAL KESELURUHAN:</td>
            <td>Rp {{ number_format($statistics['totalRevenue'], 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>
