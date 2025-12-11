<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nip')->label('NIP')->required()->maxLength(50),
                TextInput::make('name')->label('Nama Lengkap')->required()->maxLength(255),
                TextInput::make('email')->label('Email')->required()->email()->maxLength(255),
                TextInput::make('password')->label('Password')->password()->required()->minLength(8)->revealable(),
                Select::make('role')
                    ->label('Role')
                    ->options([
                        'user' => 'User',
                        'admin' => 'Admin',
                        'superadmin' => 'Superadmin',
                    ])
                    ->required(),

            ]);
    }
}
