<?php

namespace App\Filament\Resources\JenisBmns\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class JenisBmnForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 TextInput::make('jenis_bmn')
                    ->label('Nama Jenis BMN')
                    ->required()
                    ->maxLength(255),
                TextInput::make('kode_bmn')
                    ->label('Kode Jenis BMN')
                    ->required()
                    ->maxLength(100),
                
            ]);
    }
}
