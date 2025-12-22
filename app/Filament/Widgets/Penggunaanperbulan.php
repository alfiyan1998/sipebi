<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Penggunaan;
use Carbon\Carbon;

class Penggunaanperbulan extends ChartWidget
{
    protected ?string $heading = 'Penggunaan per Bulan';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $data = Penggunaan::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', Carbon::now()->year) // Filter tahun saat ini, sesuaikan jika perlu
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Inisialisasi array data untuk 12 bulan (0 jika tidak ada data)
        $monthlyData = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyData[] = $data[$month] ?? 0;
        }
        return [
            'datasets' => [
                [
                    'label' => 'Penggunaan Barang',
                    'data' => $monthlyData,
                    'backgroundColor' => 'rgba(255, 159, 64, 0.5)',
                    'borderColor' => 'rgba(255, 159, 64, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
