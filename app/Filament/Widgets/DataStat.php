<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\DataBMN as Item;
use App\Models\Penggunaan;

class DataStat extends StatsOverviewWidget
{
    protected function getStats(): array
    {

        return [
            Stat::make('Total Users', User::count())
                ->description('Jumlah total pengguna terdaftar')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
            Stat::make('Total Items', Item::count())
                ->description('Jumlah total barang tersedia')
                ->descriptionIcon('heroicon-o-archive-box')
                ->color('success'),
            Stat::make('Total Usages', Penggunaan::count())
                ->description('Jumlah total penggunaan barang')
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->color('warning'),
            Stat::make('Pending Usages', Penggunaan::where('status', 'Selesai')->count())
                ->description('Jumlah penggunaan yang selesai ')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
        ];
    }
}
