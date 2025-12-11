<?php

namespace App\Filament\Resources\Penggunaans\Pages;

use App\Filament\Resources\Penggunaans\PenggunaanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditPenggunaan extends EditRecord
{
    protected static string $resource = PenggunaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function beforeFill(): void
    {
        // Disable form fields before filling them with record data
        // $this->form->getSchema()->each(function ($component) {
        //     $component->disabled();
        // });
        $this->record->load('user', 'items');
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        $record = $this->record;
        switch ($record->status) {

        case 'Disetujui':
            // Notifikasi jika disetujui
            Notification::make()
                ->title('Pengajuan Disetujui')
                ->body("Penggunaan dengan kode {$record->kode_list} telah disetujui.")
                ->success()
                ->sendToDatabase($record->user)
                ->broadcast($record->user);
            break;


        case 'Ditolak':
            // Notifikasi jika ditolak
            Notification::make()
                ->title('Pengajuan Ditolak')
                ->body("Penggunaan dengan kode {$record->kode_list} ditolak.")
                ->danger()
                ->sendToDatabase($record->user)
                ->broadcast($record->user);
            break;


        case 'Selesai':
            // Notifikasi jika dikembalikan
            
            Notification::make()
                ->title('Barang Telah Dikembalikan')
                ->body("Barang dari kode {$record->kode_list} telah dikembalikan.")
                ->success()
                ->sendToDatabase($record->user)
                ->broadcast($record->user);
            break;

            default:
                // Opsional, kalau status tidak ditangani
                break;
        }
    }
}
