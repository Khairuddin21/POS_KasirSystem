<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #06b6d4;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #06b6d4;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 14px;
        }
        .info-section {
            margin-bottom: 20px;
            background: #f3f4f6;
            padding: 15px;
            border-radius: 5px;
        }
        .info-section p {
            margin-bottom: 5px;
        }
        .info-section strong {
            color: #06b6d4;
        }
        .statistics {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .stat-box {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 2px solid #e5e7eb;
            background: #f9fafb;
        }
        .stat-box .label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .stat-box .value {
            font-size: 18px;
            font-weight: bold;
            color: #06b6d4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table thead {
            background: #06b6d4;
            color: white;
        }
        table th {
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        table tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-cash {
            background: #d1fae5;
            color: #065f46;
        }
        .badge-qris {
            background: #dbeafe;
            color: #1e40af;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 2px solid #e5e7eb;
            padding-top: 15px;
        }
        .summary {
            margin-top: 20px;
            padding: 15px;
            background: #f0fdfa;
            border-left: 4px solid #06b6d4;
        }
        .summary h3 {
            color: #06b6d4;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TRANSAKSI PENJUALAN</h1>
        <p>POS Kasir System</p>
        <p>Periode: {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d M Y') }}</p>
        <p style="font-size: 11px; margin-top: 5px;">Dicetak: {{ now()->format('d M Y H:i:s') }}</p>
    </div>

    <div class="statistics">
        <div class="stat-box">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ number_format($statistics['totalTransactions']) }}</div>
        </div>
        <div class="stat-box">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($statistics['totalRevenue'], 0, ',', '.') }}</div>
        </div>
        <div class="stat-box">
            <div class="label">Rata-rata</div>
            <div class="value">Rp {{ number_format($statistics['avgTransaction'], 0, ',', '.') }}</div>
        </div>
        <div class="stat-box">
            <div class="label">Total Items</div>
            <div class="value">{{ number_format($statistics['totalItems']) }}</div>
        </div>
    </div>

    <div class="summary">
        <h3>Ringkasan Metode Pembayaran</h3>
        <div class="summary-row">
            <span>Cash:</span>
            <strong>Rp {{ number_format($statistics['cashRevenue'], 0, ',', '.') }}</strong>
        </div>
        <div class="summary-row">
            <span>QRIS:</span>
            <strong>Rp {{ number_format($statistics['qrisRevenue'], 0, ',', '.') }}</strong>
        </div>
    </div>

    <h3 style="margin: 20px 0 10px; color: #06b6d4; font-size: 14px;">Detail Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Member</th>
                <th class="text-center">Items</th>
                <th>Pembayaran</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $transaction)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $transaction->transaction_code }}</td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $transaction->user->name ?? '-' }}</td>
                    <td>{{ $transaction->member->name ?? 'Non Member' }}</td>
                    <td class="text-center">{{ $transaction->items->sum('quantity') }}</td>
                    <td>
                        <span class="badge {{ $transaction->payment_method == 'cash' ? 'badge-cash' : 'badge-qris' }}">
                            {{ strtoupper($transaction->payment_method) }}
                        </span>
                    </td>
                    <td class="text-right"><strong>Rp {{ number_format($transaction->total, 0, ',', '.') }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px;">Tidak ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot style="background: #f0fdfa; font-weight: bold;">
            <tr>
                <td colspan="7" class="text-right" style="padding: 10px;">TOTAL KESELURUHAN:</td>
                <td class="text-right" style="padding: 10px; color: #06b6d4; font-size: 14px;">
                    Rp {{ number_format($statistics['totalRevenue'], 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dokumen ini dicetak otomatis oleh sistem</p>
        <p>POS Kasir System - {{ config('app.name') }}</p>
    </div>
</body>
</html>
