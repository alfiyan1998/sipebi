<?php

namespace App\Filament\Resources\JenisBmns\Pages;

use App\Filament\Resources\JenisBmns\JenisBmnResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJenisBmn extends EditRecord
{
    protected static string $resource = JenisBmnResource::class;
    protected function getRedirectUrl(): string
    {
        // Mengarahkan kembali ke halaman 'index' (ListBarangs)
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
