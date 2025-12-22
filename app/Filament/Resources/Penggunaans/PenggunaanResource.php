<?php

namespace App\Filament\Resources\Penggunaans;

use App\Filament\Resources\Penggunaans\Pages\CreatePenggunaan;
use App\Filament\Resources\Penggunaans\Pages\EditPenggunaan;
use App\Filament\Resources\Penggunaans\Pages\ListPenggunaans;
use App\Filament\Resources\Penggunaans\Schemas\PenggunaanForm;
use App\Filament\Resources\Penggunaans\Tables\PenggunaansTable;
use App\Filament\Resources\Penggunaans\Pages\ViewPenggunaan;
use App\Helpers\Access;
use App\Models\Penggunaan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PenggunaanResource extends Resource
{
    protected static ?string $model = Penggunaan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Data Penggunaan';

    protected static ?string $breadcrumb = 'Penggunaan BMN';
    protected static ?string $navigationLabel = 'Penggunaan BMN';

    public static function form(Schema $schema): Schema
    {
        return PenggunaanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenggunaansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenggunaans::route('/'),
            'create' => CreatePenggunaan::route('/create'),
            'view' => ViewPenggunaan::route('/{record}'),
            'edit' => EditPenggunaan::route('/{record}/edit'),
        ];
    }

    public static function canEdit($record):bool{
        return Access::isAdminOrSuper();
    }
    public static function canDelete($record):bool{
        return Access::isAdminOrSuper();
    }

}
