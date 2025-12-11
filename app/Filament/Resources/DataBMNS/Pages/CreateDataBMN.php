<?php

namespace App\Filament\Resources\DataBMNS\Pages;

use App\Filament\Resources\DataBMNS\DataBMNResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDataBMN extends CreateRecord
{
    protected static ?string $title = 'Tambah Data BMN';
    protected static string $resource = DataBMNResource::class;

    protected function getRedirectUrl(): string
    {
        // Mengarahkan kembali ke halaman 'index' (ListBarangs)
        return $this->getResource()::getUrl('index');
    }
}
