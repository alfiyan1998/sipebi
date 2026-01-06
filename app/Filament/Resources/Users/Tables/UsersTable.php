<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama Lengkap')->sortable()->searchable(),
                TextColumn::make('nip')->label('NIP')->sortable()->searchable(),
                TextColumn::make('email')->label('Email')->sortable()->searchable(),
                TextColumn::make('created_at')->label('Dibuat Pada')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('role')->label('Role')->sortable()->searchable(),
            
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                //membuat aksi ubah passwordnya saja
                
                Action::make('changePassword')
                    ->label('Ubah Password')
                    ->color('info')
                    ->schema([
                        TextInput::make('password')
                            ->label('Password Baru')
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->revealable(),
                    ])
                    ->action(function ($record, array $data): void {
                        $record->password = bcrypt($data['password']);
                        $record->save();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
