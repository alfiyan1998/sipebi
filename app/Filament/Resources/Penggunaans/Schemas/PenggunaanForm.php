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
use App\Models\DataBmn;
use App\Models\ListPenggunaan;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;


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
                                ->required()
                                ,
                                
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
                            // SignaturePad::make('signature')
                            //     ->label('Tanda Tangan')
                            //     ->dotSize(2.0)
                            //     ->lineMinWidth(0.5)
                            //     ->lineMaxWidth(2.5)
                            //     ->throttle(16)
                            //     ->minDistance(5)
                            //     ->velocityFilterWeight(0.7)
                            //     ->backgroundColor('rgba(255,255,255,0)')
                            //     ->penColor('rgb(0, 0, 0)')
                            //     ->required(),
                    
                            ]),
                            Section::make('Daftar BMN')
                        ->schema([
                            Repeater::make('items')
                            ->relationship('items')
                            ->schema([

                                Select::make('bmn_id')
                                ->label('Nama BMN')
                                // ->options(DataBMN::all()->pluck('nama_barang', 'id'))
                                ->options(function () {
                                        return DataBMN::all()->mapWithKeys(function ($bmn) {
                                            return [$bmn->id => "[{$bmn->kode_barang}] {$bmn->nama_barang}"];
                                        });
                                    })
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
                                // ->searchable()
                                // ->rule(function($record){
                                //     return function (string $attribute, $value, $fail) use ($record) {
                                //         $sudahdigunakan = ListPenggunaan::where('bmn_id', $value)
                                //             ->whereHas('penggunaan', function ($query) {
                                //                 $query->whereIn('status', ['Diajukan', 'Disetujui']);
                                //             })
                                //             ->exists();
                                //         if ($sudahdigunakan) {
                                //             $fail('Barang sudah digunakan dalam penggunaan dengan status Diajukan atau Disetujui.');
                                //         }
                                //     };
                                // }),
                                // TextInput::make('kode_barang')
                                //     ->label('Kode Barang')
                                //     ->disabled()
                                //     ->dehydrated(false)
                                //     ->default(fn (callable $get) => DataBMN::find($get('bmn_id'))->kode_barang ?? '-'),
                                
                            ])
                            ->required()
                    // ->itemLabel(fn (array $state): string => Barang::find($state['items'])->nama_barang ?? 'Item'),
                            ->itemLabel(fn(array $state) : ?string => DataBmn::find($state['bmn_id'])->nama_barang ?? 'Item'),                    
                        ])
            ]);
    }
}
