<?php

namespace App\Filament\Resources\JenisBmns\Pages;

use App\Filament\Resources\JenisBmns\JenisBmnResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJenisBmn extends CreateRecord
{
    
    protected static string $resource = JenisBmnResource::class;
    protected function getRedirectUrl(): string
    {
        // Mengarahkan kembali ke halaman 'index' (ListBarangs)
        return $this->getResource()::getUrl('index');
    }
}
