<?php

namespace App\Filament\Resources\Penggunaans\Pages;

use App\Filament\Resources\Penggunaans\PenggunaanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;


class ViewPenggunaan extends ViewRecord
{
    protected static string $resource = PenggunaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('cetakPdf')
                ->label('Cetak PDF')
                ->icon('heroicon-o-printer')
                ->visible(fn () => $this->record->status === 'Digunakan' || $this->record->status === 'Selesai')
                ->action(function () {
                    $pdf = Pdf::loadView('pdf.new', [
                        'peminjaman' => $this->record,
                    ]);

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'Suket-IzinPenggunaan-' . $this->record->kode_list . '.pdf'
                    );
                }),
        ];
    }
}
