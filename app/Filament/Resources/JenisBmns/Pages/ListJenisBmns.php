<?php

namespace App\Filament\Resources\JenisBmns\Pages;

use App\Filament\Resources\JenisBmns\JenisBmnResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJenisBmns extends ListRecords
{
    protected static ?string $title = 'Jenis BMN';
    protected static string $resource = JenisBmnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Jenis BMN'),
        ];
    }
}
