<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Page;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Register extends BaseRegister
{
    // protected string $view = 'filament.pages.auth.register';
    // public function getRegisterCredentialsFromFormData(array $data): array
    // {
    //     return [
    //         'name' => $data['name'],
    //         'nip' => $data['nip'],
    //         'email' => $data['email'],
    //         'password' => $data['password'],
    //         'role' => $data['role']
    //     ];
    // }
    // public function form(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             TextInput::make('name')
    //                 ->required()
    //                 ->label('Nama Lengkap'),

    //             TextInput::make('nip')
    //                 ->required()
    //                 ->label('NIP')
    //                 //verifikasi NIP yang terdaftar
    //                 ->rule(function ($attribute, $value, $fail) {
    //                     // Cek apakah NIP sudah terdaftar
    //                     $exists = User::where('nip', $value)->exists();
    //                     if ($exists) {
    //                         $fail('NIP sudah terdaftar.');
    //                     }
    //                 })
    //                 ->minLength(18)
    //                 ->maxLength(18),

    //             TextInput::make('email')
    //                 ->required()
    //                 ->label('Email Anda')
    //                 ->email()
    //                 //verifikasi email yang terdaftar
    //                 ->rule(function ($attribute, $value, $fail) {
    //                     // Cek apakah email sudah terdaftar
    //                     $exists = User::where('email', $value)->exists();
    //                     if ($exists) {
    //                         $fail('Email sudah terdaftar.');
    //                     }
    //                 }),

    //             TextInput::make('password')
    //                 ->password()
    //                 ->required()
    //                 ->revealable(),
    //             TextInput::make('role')
    //                 ->default('user')
    //                 ->hidden(),

    //         ]);
    // }
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->label('Nama Lengkap')
                    ->maxLength(255),

                TextInput::make('nip')
                    ->required()
                    ->label('NIP')
                    ->unique(User::class, 'nip')
                    ->length(18)
                    ->validationMessages([
                        'unique' => 'NIP sudah terdaftar.',
                        'length' => 'NIP harus 18 karakter.',
                    ]),

                TextInput::make('email')
                    ->required()
                    ->label('Email Anda')
                    ->email()
                    ->unique(User::class, 'email')
                    ->validationMessages([
                        'unique' => 'Email sudah terdaftar.',
                    ]),

                TextInput::make('password')
                    ->password()
                    ->required()
                    ->revealable()
                    ->confirmed()
                    ->minLength(8),

                TextInput::make('password_confirmation')
                    ->password()
                    ->required()
                    ->label('Konfirmasi Password')
                    ->revealable()
                    ->dehydrated(false),
            ]);
    }

    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['role'] = 'user';
        $data['password'] = Hash::make($data['password']);
        
        return $data;
    }
}
