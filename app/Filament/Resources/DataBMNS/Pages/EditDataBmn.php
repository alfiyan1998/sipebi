<?php

namespace App\Filament\Resources\DataBmns\Pages;

use App\Filament\Resources\DataBmns\DataBmnResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDataBmn extends EditRecord
{
    protected static string $resource = DataBmnResource::class;

    protected function getRedirectUrl(): string
    {
        // Mengarahkan kembali ke halaman 'index' (ListBarangs)
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus Data BMN')
                ->requiresConfirmation()
                ->modalHeading('Hapus Data BMN')
                ->modalSubheading('Apakah Anda yakin ingin menghapus data BMN ini? Tindakan ini tidak dapat dibatalkan.')
                ->color('danger')
                ->visible(fn (): bool => DataBmnResource::canDelete($this->record)),
        ];
    }
}
