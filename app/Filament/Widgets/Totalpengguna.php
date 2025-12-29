<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;

class Totalpengguna extends ChartWidget
{
    protected ?string $heading = 'Total Pengguna';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        
        $totalPengguna = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $dummyData = [];
        for ($month = 1; $month <= 12; $month++) {
            $dummyData[$month - 1] = $totalPengguna[$month] ?? 0;
        }
 

        return [
            'datasets' => [
                [
                    'label' => 'Total pengguna',
                    'data' => $totalPengguna,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                    'fill' => 'start',
                ],
            ]
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
