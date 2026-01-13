<?php

namespace App\Filament\Resources\Penggunaans\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use App\Models\DataBmn;
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
                                    ->disabled(fn (string $context) => $context === 'create')
                                    ->dehydrated()
                                    ->searchable()
                                    ->required(),
                                    
                                DatePicker::make('tanggal_penggunaan')
                                    ->label('Tanggal Penggunaan')
                                    ->default(now())
                                    ->required()
                                    ->minDate(now())
                                    ->dehydrated(false),
                            
                                DatePicker::make('tanggal_kembali')
                                    ->label('Tanggal Kembali')
                                    ->minDate(now())
                                    ->required(),
                                    
                                TextInput::make('kode_list')
                                    ->label('Kode List')
                                    ->default(fn () => 'PL-' . strtoupper(uniqid()))
                                    ->readOnly()
                                    ->required(),
                                    
                                Select::make('status')
                                    ->options([
                                        'Diajukan' => 'Diajukan',
                                        'Digunakan' => 'Disetujui',
                                        'Ditolak' => 'Ditolak',
                                        'Selesai' => 'Dikembalikan',
                                    ])
                                    ->visibleOn('edit')
                                    ->label('Status'),
                            ]),
                    ]),
                    
                Section::make('Daftar BMN')
                    ->schema([
                        Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                Select::make('bmn_id')
                                    ->label('Nama BMN')
                                    ->options(function () {
                                        return DataBMN::all()->mapWithKeys(function ($bmn) {
                                            return [$bmn->id => "[{$bmn->kode_barang}] {$bmn->nama_barang}"];
                                        });
                                    })
                                    ->searchable()
                                    ->required()
                                    ->rule(function ($record, $get) {
                                        return function (string $attribute, $value, $fail) use ($record, $get) {
                                            // Ambil ID item yang sedang diedit
                                            $currentItemId = $get('id');
                                            
                                            // Cek apakah barang sudah digunakan
                                            $sudahDigunakan = ListPenggunaan::where('bmn_id', $value)
                                                ->when($currentItemId, function ($query) use ($currentItemId) {
                                                    // Skip item yang sedang diedit
                                                    $query->where('id', '!=', $currentItemId);
                                                })
                                                ->whereHas('penggunaan', function ($query) use ($record) {
                                                    $query->whereIn('status', ['Diajukan', 'Disetujui'])
                                                          // Kecualikan penggunaan yang sedang diedit
                                                          ->when($record, function ($q) use ($record) {
                                                              $q->where('id', '!=', $record->id);
                                                          });
                                                })
                                                ->exists();
                                            
                                            if ($sudahDigunakan) {
                                                $fail('Barang sudah digunakan dalam penggunaan dengan status Diajukan atau Disetujui.');
                                            }
                                        };
                                    }),
                            ])
                            ->required()
                            ->itemLabel(fn(array $state) : ?string => DataBmn::find($state['bmn_id'])->nama_barang ?? 'Item'),
                    ])
            ]);
    }
}