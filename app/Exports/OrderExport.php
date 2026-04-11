<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class OrderExport implements FromCollection, WithHeadings
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders->map(function ($o) {
            return [
                $o->id,
                $o->customer_name ?? 'NON-MEMBER',
                Carbon::parse($o->created_at)->format('Y-m-d H:i:s'),
                $o->total_price,
                $o->paid,
                $o->change,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Pelanggan',
            'Tanggal',
            'Total Harga',
            'Bayar',
            'Kembalian'
        ];
    }
}