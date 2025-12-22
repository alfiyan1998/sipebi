<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Penggunaans\PenggunaanResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Penggunaan;

class Recentpenggunaan extends TableWidget
{
    
     protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;


    public function table(Table $table): Table
    {
        return $table
            ->heading('Penggunaan Terbaru')
            ->query(fn (): Builder => Penggunaan::query())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('kode_list')->label('Kode List')->searchable()->sortable(),
                TextColumn::make('user.name')->label('Nama Pengguna')->searchable()->sortable(),
                TextColumn::make('tanggal_penggunaan')->label('Tanggal Penggunaan')->date()->sortable(),
                TextColumn::make('status')->label('Status')->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('view')
                    ->label('Lihat')
                    ->url(fn (Penggunaan $record) => PenggunaanResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
