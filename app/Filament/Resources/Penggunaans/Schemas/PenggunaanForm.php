<?php

namespace App\Filament\Resources\Penggunaans\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
// use App\Filament\Resources\Penggunaans\Pages\ListPenggunaan;
use App\Models\DataBMN;
use App\Models\ListPenggunaan;


class PenggunaanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pengguna')
                ->description('Informasi mengenai pengguna dan detail penggunaan barang.')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Select::make('user_id')
                                ->label('Nama Pengguna')
                                ->relationship('user', 'name')
                                ->default(fn () => auth()->id())
                                ->disabled(fn (string $context) => $context === 'create') // hanya lock di create
                                ->dehydrated() // tetap disimpan
                                ->searchable()
                                ->required(),
                            DatePicker::make('tanggal_penggunaan')
                                ->label('Tanggal Penggunaan')
                                ->default(now())
                                ->disabled()
                                ->dehydrated(false),
                        
                            DatePicker::make('tanggal_kembali')
                                ->label('Tanggal Kembali')
                                ->minDate(now())
                                ->nullable(),
                                
                            TextInput::make('kode_list')
                                ->label('Kode List')
                                ->default(fn () => 'PL-' . strtoupper(uniqid()))
                                ->readOnly()
                                ->required(),
                            Select::make('status')
                                ->options([
                                    'Diajukan' => 'Diajukan',
                                    'Disetujui' => 'Disetujui',
                                    'Ditolak' => 'Ditolak',
                                    'Selesai' => 'Dikembalikan',
                                ])
                                ->visibleOn('edit')
                                ->label('Status'),
                                ]),
                    
                            ]),
                            Section::make('Daftar Barang Digunakan')
                        ->schema([
                            Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                Select::make('bmn_id')
                                ->label('Nama Barang')
                                ->options(DataBMN::all()->pluck('nama_barang', 'id'))
                                ->searchable()
                                ->rule(function($record){
                                    return function (string $attribute, $value, $fail) use ($record) {
                                        $sudahdigunakan = ListPenggunaan::where('bmn_id', $value)
                                            ->whereHas('penggunaan', function ($query) {
                                                $query->whereIn('status', ['Diajukan', 'Disetujui']);
                                            })
                                            ->exists();
                                        if ($sudahdigunakan) {
                                            $fail('Barang sudah digunakan dalam penggunaan dengan status Diajukan atau Disetujui.');
                                        }
                                    };
                                }),
                                
                            ])
                            ->required()
                    // ->itemLabel(fn (array $state): string => Barang::find($state['items'])->nama_barang ?? 'Item'),
                            ->itemLabel(fn(array $state) : ?string => DataBMN::find($state['bmn_id'])->nama_barang ?? 'Item'),                    
                        ])
            ]);
    }
}
