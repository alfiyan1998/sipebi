<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Page;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class Register extends BaseRegister
{
    // protected string $view = 'filament.pages.auth.register';
    public function getRegisterCredentialsFromFormData(array $data): array
    {
        return [
            'name' => $data['name'],
            'nip' => $data['nip'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role']
        ];
    }
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->label('Nama Lengkap'),

                TextInput::make('nip')
                    ->required()
                    ->label('NIP')
                    
                    ->minLength(18)
                    ->maxLength(18),

                TextInput::make('email')
                    ->required()
                    ->label('Email Anda'),

                TextInput::make('password')
                    ->password()
                    ->required()
                    ->revealable(),
                TextInput::make('role')
                    ->default('user')
                    ->hidden(),

            ]);
    }
}
