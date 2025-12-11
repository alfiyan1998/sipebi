<?php

namespace App\Filament\Resources\DataBMNS\Pages;

use App\Filament\Resources\DataBMNS\DataBMNResource;
use App\Imports\BarangImport;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Maatwebsite\Excel\Excel;
use Filament\Actions\Action;


class ListDataBMNS extends ListRecords
{
    protected static ?string $title = 'Data BMN';
    protected static string $resource = DataBMNResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Data BMN')
            ->visible(fn () => DataBMNResource::canCreate()),
            Action::make('import')
                ->label('Import Data')
                ->visible(fn () => DataBMNResource::canCreate())
                ->icon(Heroicon::ArrowDown)
                ->modalHeading('Import Data BMN')
                ->modalWidth('md')
                ->form([
                    FileUpload::make('file')
                        ->label('Pilih File Excel')
                        ->required(),
                        // ->acceptedFileTypes(['.xlsx', '.xls']),
                ])
                ->action(function (array $data, Excel $excel) { // <--- TAMBAHKAN 'Excel $excel' DI SINI

                // Panggil metode import() melalui instance $excel yang sudah diinjeksikan
                $excel->import(new BarangImport, $data['file']);

                Notification::make()
                    ->title('Import berhasil!')
                    ->body('Data BMN berhasil diimpor dari file Excel.')
                    ->success()
                    ->send();
            })
        ];
    }
}
