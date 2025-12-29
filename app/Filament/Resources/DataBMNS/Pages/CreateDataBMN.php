<?php

namespace App\Filament\Resources\DataBmns\Pages;

use App\Filament\Resources\DataBmns\DataBmnResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDataBmn extends CreateRecord
{
    protected static ?string $title = 'Tambah Data BMN';
    protected static string $resource = DataBmnResource::class;

    protected function getRedirectUrl(): string
    {
        // Mengarahkan kembali ke halaman 'index' (ListBarangs)
        return $this->getResource()::getUrl('index');
    }
}
