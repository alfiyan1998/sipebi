<?php

namespace App\Filament\Resources\JenisBmns\Pages;

use App\Filament\Resources\JenisBmns\JenisBmnResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJenisBmns extends ListRecords
{
    protected static string $resource = JenisBmnResource::class;

    public static ?string $title = 'Daftar Jenis BMN';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Buat Jenis BMN Baru'),
        ];
    }
}
