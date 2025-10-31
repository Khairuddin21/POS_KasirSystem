<table>
    <thead>
        <tr>
            <th colspan="8" style="text-align: center; font-size: 16px; font-weight: bold;">LAPORAN PENJUALAN KASIR</th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center;">Periode: {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d M Y') }}</th>
        </tr>
        <tr><th colspan="8"></th></tr>
        <tr>
            <th colspan="2" style="font-weight: bold;">Total Transaksi:</th>
            <th>{{ $statistics['totalTransactions'] }}</th>
            <th colspan="2" style="font-weight: bold;">Total Penjualan:</th>
            <th colspan="3">Rp {{ number_format($statistics['totalSales'], 0, ',', '.') }}</th>
        </tr>
        <tr>
            <th colspan="2" style="font-weight: bold;">Total Item:</th>
            <th>{{ $statistics['totalItems'] }}</th>
            <th colspan="2" style="font-weight: bold;">Rata-rata Transaksi:</th>
            <th colspan="3">Rp {{ number_format($statistics['avgTransaction'], 0, ',', '.') }}</th>
        </tr>
        <tr><th colspan="8"></th></tr>
        <tr style="background-color: #3b82f6; color: white; font-weight: bold;">
            <th>No</th>
            <th>Kode Transaksi</th>
            <th>Tanggal</th>
            <th>Kasir</th>
            <th>Pelanggan</th>
            <th>Items</th>
            <th>Total</th>
            <th>Metode Bayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $index => $transaction)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $transaction->transaction_code }}</td>
            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $transaction->user->name }}</td>
            <td>{{ $transaction->member ? $transaction->member->name : 'Umum' }}</td>
            <td>{{ $transaction->items->sum('quantity') }}</td>
            <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
            <td>{{ ucfirst($transaction->payment_method) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
