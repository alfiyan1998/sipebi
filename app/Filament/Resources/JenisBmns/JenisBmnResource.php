<?php

namespace App\Filament\Resources\JenisBmns;

use App\Filament\Resources\JenisBmns\Pages\CreateJenisBmn;
use App\Filament\Resources\JenisBmns\Pages\EditJenisBmn;
use App\Filament\Resources\JenisBmns\Pages\ListJenisBmns;
use App\Filament\Resources\JenisBmns\Schemas\JenisBmnForm;
use App\Filament\Resources\JenisBmns\Tables\JenisBmnsTable;
use App\Models\JenisBmn;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Helpers\Access;

class JenisBmnResource extends Resource
{
    protected static ?string $model = JenisBmn::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CircleStack;

    protected static ?string $recordTitleAttribute = 'JenisBmn';
    public static ?string $breadcrumb = 'Jenis BMN';
    public static ?string $navigationLabel = 'Jenis BMN';

    public static function form(Schema $schema): Schema
    {
        return JenisBmnForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JenisBmnsTable::configure($table);
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
            'index' => ListJenisBmns::route('/'),
            'create' => CreateJenisBmn::route('/create'),
            'edit' => EditJenisBmn::route('/{record}/edit'),
        ];
    }

       public static function canAccess(): bool
    {
        return Access::isAdminOrSuper();
    }
}
