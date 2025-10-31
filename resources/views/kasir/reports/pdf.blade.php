<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            color: #1e40af;
            margin-bottom: 10px;
        }
        .header p {
            font-size: 14px;
            color: #6b7280;
        }
        .info-box {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin-bottom: 20px;
        }
        .info-box .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .info-box .label {
            font-weight: bold;
            color: #1e40af;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-card .value {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stat-card .label {
            font-size: 11px;
            opacity: 0.9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table thead {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
        }
        table th {
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        table tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        table tbody tr:hover {
            background: #eff6ff;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            color: #6b7280;
            font-size: 11px;
        }
        .footer .signature {
            margin-top: 60px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 LAPORAN PENJUALAN KASIR</h1>
        <p>EMPUSHOP - Sistem POS Terpadu</p>
    </div>

    <div class="info-box">
        <div class="row">
            <div><span class="label">Periode:</span> {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d M Y') }}</div>
            <div><span class="label">Kasir:</span> {{ $cashier }}</div>
        </div>
        <div class="row">
            <div><span class="label">Tanggal Cetak:</span> {{ now()->format('d M Y H:i') }}</div>
        </div>
    </div>

    <div class="stats">
        <div class="stat-card">
            <div class="value">{{ $statistics['totalTransactions'] }}</div>
            <div class="label">Total Transaksi</div>
        </div>
        <div class="stat-card">
            <div class="value">Rp {{ number_format($statistics['totalSales'], 0, ',', '.') }}</div>
            <div class="label">Total Penjualan</div>
        </div>
        <div class="stat-card">
            <div class="value">{{ $statistics['totalItems'] }}</div>
            <div class="label">Total Item</div>
        </div>
        <div class="stat-card">
            <div class="value">Rp {{ number_format($statistics['avgTransaction'], 0, ',', '.') }}</div>
            <div class="label">Rata-rata</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Kode Transaksi</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 15%;">Kasir</th>
                <th style="width: 15%;">Pelanggan</th>
                <th style="width: 10%;">Items</th>
                <th style="width: 15%;">Total</th>
                <th style="width: 10%;">Metode</th>
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
                <td style="text-align: center;">{{ $transaction->items->sum('quantity') }}</td>
                <td style="text-align: right; font-weight: bold; color: #059669;">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                <td>{{ ucfirst($transaction->payment_method) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem POS EMPUSHOP</p>
        <p>Jl. Contoh No. 123, Jakarta | Telp: (021) 1234-5678 | Email: info@empushop.com</p>
        
        <div class="signature">
            <p>{{ now()->format('d M Y') }}</p>
            <br><br><br>
            <p>_____________________</p>
            <p><strong>{{ $cashier }}</strong></p>
            <p>Kasir</p>
        </div>
    </div>
</body>
</html>
