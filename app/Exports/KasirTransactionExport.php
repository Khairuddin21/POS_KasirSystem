<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KasirTransactionExport implements FromView, WithTitle, WithStyles
{
    protected $transactions;
    protected $dateFrom;
    protected $dateTo;

    public function __construct($transactions, $dateFrom, $dateTo)
    {
        $this->transactions = $transactions;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function view(): View
    {
        $statistics = [
            'totalTransactions' => $this->transactions->count(),
            'totalSales' => $this->transactions->sum('total'),
            'totalItems' => $this->transactions->sum(function($transaction) {
                return $transaction->items->sum('quantity');
            }),
            'avgTransaction' => $this->transactions->count() > 0 ? $this->transactions->avg('total') : 0,
        ];

        return view('kasir.reports.excel', [
            'transactions' => $this->transactions,
            'statistics' => $statistics,
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo,
        ]);
    }

    public function title(): string
    {
        return 'Laporan Penjualan';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            3 => ['font' => ['bold' => true, 'size' => 12]],
            5 => ['font' => ['bold' => true]],
        ];
    }
}
