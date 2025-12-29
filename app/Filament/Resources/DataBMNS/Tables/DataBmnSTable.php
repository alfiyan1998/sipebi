<?php

namespace App\Filament\Resources\DataBmns\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Helpers\Access;

class DataBmnsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_barang')->label('Kode Barang')->sortable(),
                TextColumn::make('nama_barang')->label('Nama Barang')->sortable(),
                TextColumn::make('jenisbmn.jenis_bmn')->label('Jenis BMN'),
            ])
            ->searchable()
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                ->visible(fn ($record) => Access::isAdminOrSuper()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                    ->visible(fn () => Access::isAdminOrSuper()),
                ]),
            ]);
    }
}
