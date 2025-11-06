<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class AdminTransactionExport
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

    public function download($filename)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Transaksi Admin');

        // Title
        $sheet->setCellValue('A1', 'LAPORAN TRANSAKSI PENJUALAN');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Period
        $sheet->setCellValue('A2', 'Periode: ' . \Carbon\Carbon::parse($this->dateFrom)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($this->dateTo)->format('d M Y'));
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Statistics
        $statistics = [
            'totalTransactions' => $this->transactions->count(),
            'totalRevenue' => $this->transactions->sum('total'),
            'totalItems' => $this->transactions->sum(function($transaction) {
                return $transaction->items->sum('quantity');
            }),
            'avgTransaction' => $this->transactions->count() > 0 ? $this->transactions->avg('total') : 0,
            'cashRevenue' => $this->transactions->where('payment_method', 'cash')->sum('total'),
            'qrisRevenue' => $this->transactions->where('payment_method', 'qris')->sum('total'),
        ];

        $row = 4;
        $sheet->setCellValue('A' . $row, 'Total Transaksi:');
        $sheet->setCellValue('B' . $row, number_format($statistics['totalTransactions']));
        $sheet->setCellValue('D' . $row, 'Total Pendapatan:');
        $sheet->setCellValue('E' . $row, 'Rp ' . number_format($statistics['totalRevenue'], 0, ',', '.'));
        $sheet->getStyle('A' . $row . ':B' . $row)->getFont()->setBold(true);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);

        $row++;
        $sheet->setCellValue('A' . $row, 'Total Items:');
        $sheet->setCellValue('B' . $row, number_format($statistics['totalItems']));
        $sheet->setCellValue('D' . $row, 'Rata-rata Transaksi:');
        $sheet->setCellValue('E' . $row, 'Rp ' . number_format($statistics['avgTransaction'], 0, ',', '.'));
        $sheet->getStyle('A' . $row . ':B' . $row)->getFont()->setBold(true);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);

        $row++;
        $sheet->setCellValue('A' . $row, 'Cash Revenue:');
        $sheet->setCellValue('B' . $row, 'Rp ' . number_format($statistics['cashRevenue'], 0, ',', '.'));
        $sheet->setCellValue('D' . $row, 'QRIS Revenue:');
        $sheet->setCellValue('E' . $row, 'Rp ' . number_format($statistics['qrisRevenue'], 0, ',', '.'));
        $sheet->getStyle('A' . $row . ':B' . $row)->getFont()->setBold(true);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);

        // Headers
        $row = 8;
        $headers = ['No', 'Invoice Number', 'Tanggal', 'Kasir', 'Member', 'Items', 'Metode Pembayaran', 'Total'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $col++;
        }
        $sheet->getStyle('A' . $row . ':H' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row . ':H' . $row)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF06b6d4');
        $sheet->getStyle('A' . $row . ':H' . $row)->getFont()->getColor()->setARGB('FFFFFFFF');

        // Data
        $row++;
        foreach ($this->transactions as $index => $transaction) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $transaction->transaction_code);
            $sheet->setCellValue('C' . $row, $transaction->created_at->format('d/m/Y H:i:s'));
            $sheet->setCellValue('D' . $row, $transaction->user->name ?? '-');
            $sheet->setCellValue('E' . $row, $transaction->member->name ?? 'Non Member');
            $sheet->setCellValue('F' . $row, $transaction->items->sum('quantity'));
            $sheet->setCellValue('G' . $row, strtoupper($transaction->payment_method));
            $sheet->setCellValue('H' . $row, number_format($transaction->total, 0, ',', '.'));
            $row++;
        }

        // Total Footer
        $sheet->setCellValue('G' . $row, 'TOTAL KESELURUHAN:');
        $sheet->setCellValue('H' . $row, 'Rp ' . number_format($statistics['totalRevenue'], 0, ',', '.'));
        $sheet->getStyle('G' . $row . ':H' . $row)->getFont()->setBold(true);
        $sheet->getStyle('G' . $row . ':H' . $row)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFe0f7fa');

        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Save file
        $writer = new Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}
