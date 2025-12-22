<?php

namespace App\Filament\Exports;

use App\Models\Penggunaan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PenggunaanExporter extends Exporter
{
    protected static ?string $model = Penggunaan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('kode_list')
                ->label('Kode Penggunaan'),

            ExportColumn::make('user.name')
                ->label('Nama User'),

            ExportColumn::make('barang.nama_barang')
                ->label('Barang'),

            ExportColumn::make('tanggal_mulai')
                ->label('Tanggal Mulai'),

            ExportColumn::make('tanggal_selesai')
                ->label('Tanggal Selesai'),

            ExportColumn::make('status')
                ->label('Status'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Data Penggunaan berhasil di export dan ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
