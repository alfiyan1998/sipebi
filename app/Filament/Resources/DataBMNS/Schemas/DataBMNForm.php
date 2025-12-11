<?php

namespace App\Filament\Resources\DataBMNS\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use App\Models\JenisBmn;

class DataBMNForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pokok Barang')
                ->description('Informasi unik dan kategorisasi barang.')
                ->schema([
                    Grid::make(2) // Atur agar field di dalamnya menjadi 2 kolom
                        ->schema([
                            // Kolom Kiri
                            TextInput::make('kode_barang')
                                ->unique(ignoreRecord: true)
                                ->required()
                                ->maxLength(255),
                            
                            // Kolom Kanan (Relasi)
                            Select::make('jenis_bmn_id')
                                ->label('Jenis BMN')
                                ->options(JenisBmn::pluck('jenis_bmn', 'id'))
                                ->searchable()
                                ->required(),
                        ]),
                        
                    TextInput::make('nama_barang')
                        ->label('Nama Barang')
                        ->required()
                        ->maxLength(255),
                ]),
            
            // 2. SECTION: Detail Inventaris dan Stok
            Section::make('Detail Inventaris dan Stok')
                ->columns(3) // Section ini diatur menjadi 3 kolom
                ->schema([
                    TextInput::make('merk')
                        ->required(),  
                ]),
                
            ]);
    }
}
