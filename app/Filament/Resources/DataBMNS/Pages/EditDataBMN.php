<?php

namespace App\Filament\Resources\DataBMNS\Pages;

use App\Filament\Resources\DataBMNS\DataBMNResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDataBMN extends EditRecord
{
    protected static string $resource = DataBMNResource::class;

    protected function getRedirectUrl(): string
    {
        // Mengarahkan kembali ke halaman 'index' (ListBarangs)
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
            ->visible(fn () => DataBMNResource::canDelete($this->record)),
        ];
    }
}
