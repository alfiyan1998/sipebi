<?php

namespace App\Filament\Resources\Penggunaans\Tables;

use App\Helpers\Access;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Actions\Action;

use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Textarea;
use App\Notifications\PenggunaanStatusMail;
use Filament\Actions\ExportAction;
use App\Filament\Exports\PenggunaanExporter;

class PenggunaansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                ->exporter(PenggunaanExporter::class)
                ->label('Export Data')
                ->icon('heroicon-o-arrow-down-tray')
                ->visible(fn (): bool => Access::isAdminOrSuper())
                ->modifyQueryUsing(fn ($query) =>
                    $query->where('status', 'Selesai')),
            ])
            ->columns([
                TextColumn::make('kode_list')->label('Kode List')->searchable()->sortable(),
                TextColumn::make('user.name')->label('Nama Pengguna')->searchable()->sortable(),
                TextColumn::make('tanggal_penggunaan')->label('Tanggal Penggunaan')->date()->sortable(),
                TextColumn::make('tanggal_kembali')->label('Tanggal Kembali')->date()->sortable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'primary' => 'Diajukan',
                        'warning' => 'Digunakan',
                        'success' => 'Selesai',
                        'danger' => 'Ditolak',
                    ])
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                        ViewAction::make(
                            'view'
                        ),    
                        Action::make('Setujui')
                        ->label('Setujui')
                        ->icon('heroicon-o-check')
                        ->visible(fn ($record) =>
                         Access::isAdminOrSuper() && $record->status === 'Diajukan')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Setujui Penggunaan')
                        ->modalDescription('Apakah Anda yakin ingin menyetujui penggunaan ini?')
                        ->modalSubmitActionLabel('Setujui')
                        ->action(function ($record) {

                            // Update status
                            $record->update([
                                'status' => 'Digunakan',
                            ]);

                            // Notifikasi ke user → Realtime + Database
                            Notification::make()
                                ->title('Penggunaan Disetujui')
                                ->body('Pengajuan penggunaan Anda disetujui dan status berubah menjadi "Digunakan".')
                                ->success()
                                ->actions([
                                    Action::make('lihat')
                                        ->button()
                                        ->markAsRead()
                                        ->url(fn () => route('filament.admin.resources.penggunaans.view', ['record' => $record->id])),
                                ])
                                ->sendToDatabase($record->user)
                                ->broadcast($record->user);
                            //kirim ke email user
                            $record->user->notify(
                                new PenggunaanStatusMail(
                                    'Penggunaan Disetujui',
                                    'Silakan ambil barang yang Anda ingin gunakan. Terima kasih.'
                                )
                                );    
                        }),                       
                        // Action::make('Ditolak')
                        //     ->label('Ditolak')
                        //     ->icon('heroicon-o-x-mark')
                        //     ->color('danger')
                        //     ->visible(fn ($record) => Access::isAdminOrSuper() && $record->status === 'Diajukan' )
                        //     ->form([
                        //         Textarea::make('alasan')
                        //         ->label('alasan penolakan')
                        //         ->required(),
                        //     ])
                        //     ->requiresConfirmation()
                        //     ->modalHeading('Tolak Penggunaan')
                        //     ->modalDescription('Apakah Anda yakin ingin menolak penggunaan ini? Silakan berikan alasan penolakan.')
                        //     ->modalSubmitActionLabel('Tolak')
                        //     ->action(function ($record, array $data){
                        //         $record->update([
                        //             'status' => 'Ditolak',
                        //             // 'alasan_penolakan' => $data['alasan'], 
                        //         ]);
                        //         Notification::make()
                        //         ->title('Penggunaan Ditolak')
                        //         ->body('pengajuan anda ditolak. Alasan: '. $data['alasan'])
                        //         ->danger()
                        //         ->actions([
                        //             Action::make('lihat')
                        //             ->button()
                        //             ->markAsRead()
                        //             ->url(fn () => route('filament.admin.resources.penggunaans.view', ['record' => $record->id])),
                        //             // ->url(route('filament.admin.resources.penggunaans.view', $record->id)),
                        //         ])
                        //         ->sendToDatabase($record->user)
                        //         ->broadcast($record->user);
                        //         //kirim ke email user
                        //         $record->user->notify(
                        //             new PenggunaanStatusMail(
                        //                 'Penggunaan Ditolak',  
                        //                 'Maaf, pengajuan penggunaan Anda ditolak. Alasan: ' . $data['alasan'],
                        //             )
                        //         );
                        //     }),
                        Action::make('Ditolak')
                        ->label('Ditolak')
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->visible(fn ($record) => Access::isAdminOrSuper() && $record->status === 'Diajukan' )
                        ->form([
                            Textarea::make('alasan')
                                ->label('Alasan penolakan')
                                ->required(),
                        ])
                        ->requiresConfirmation()
                        ->modalHeading('Tolak Penggunaan')
                        ->modalDescription('Apakah Anda yakin ingin menolak penggunaan ini? Silakan berikan alasan penolakan.')
                        ->modalSubmitActionLabel('Tolak')
                        ->action(function ($record, array $data){
                            // Update hanya status, TIDAK simpan alasan_penolakan
                            $record->update([
                                'status' => 'Ditolak',
                                // 👈 Hapus baris: 'alasan_penolakan' => $data['alasan'],
                            ]);
                            
                            // Notifikasi database & broadcast
                            Notification::make()
                                ->title('Penggunaan Ditolak')
                                ->body('Pengajuan Anda ditolak. Alasan: '. $data['alasan'])
                                ->danger()
                                ->actions([
                                    Action::make('lihat')
                                        ->button()
                                        ->markAsRead()
                                        ->url(fn () => route('filament.admin.resources.penggunaans.view', ['record' => $record->id])),
                                ])
                                ->sendToDatabase($record->user)
                                ->broadcast($record->user);
                            
                            // Kirim email dengan alasan
                            $record->user->notify(
                                new PenggunaanStatusMail(
                                    'Penggunaan Ditolak',  
                                    'Maaf, pengajuan penggunaan Anda ditolak. Alasan: ' . $data['alasan'],
                                )
                            );
                        }),
                        DeleteAction::make(),
                        EditAction::make()
                        ->name('edit')
                        ->visible(fn () => Access::isAdminOrSuper()),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    
                    DeleteBulkAction::make()
                    ->visible(fn (): bool => Access::isAdminOrSuper()),
                ]),
            ]);
    }
}
