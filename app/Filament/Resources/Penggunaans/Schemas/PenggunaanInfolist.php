<?php

namespace App\Filament\Resources\Penggunaans\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PenggunaanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                TextEntry::make('nama_pengguna')
                    ->label('Nama Pengguna'),
                TextEntry::make('tanggal_penggunaan')
                    ->label('Tanggal Penggunaan'),
                TextEntry::make('tanggal_kembali')
                    ->label('Tanggal Kembali'),
                TextEntry::make('kode_list')
                    ->label('Kode List'),
                TextEntry::make('status')
                    ->label('Status'),
                    ]),
                    RepeatableEntry::make('items')
                    ->label('Daftar Barang Digunakan')
                    ->schema([
                        TextEntry::make('data_bmn.nama_barang')
                            ->label('Nama Barang'),
                    ])
            ]);
    }
}
