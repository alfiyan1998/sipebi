<?php

namespace App\Filament\Resources\DataBmns;

use App\Filament\Resources\DataBmns\Pages\CreateDataBmn;
use App\Filament\Resources\DataBmns\Pages\EditDataBmn;
use App\Filament\Resources\DataBmns\Pages\ListDataBmns;
use App\Filament\Resources\DataBmns\Schemas\DataBmnForm;
use App\Filament\Resources\DataBmns\Tables\DataBmnsTable;
use App\Helpers\Access;
use App\Models\DataBmn;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DataBmnResource extends Resource
{
    protected static ?string $model = DataBmn::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArchiveBoxArrowDown;

    protected static ?string $recordTitleAttribute = 'DataBmn';

    public static ?string $breadcrumb = 'Data BMN';

    public static ?string $navigationLabel = 'Data BMN';    

    public static function form(Schema $schema): Schema
    {
        return DataBmnForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DataBmnsTable::configure($table);
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
            'index' => ListDataBmns::route('/'),
            'create' => CreateDataBmn::route('/create'),
            'edit' => EditDataBmn::route('/{record}/edit'),
        ];
    }

     public static function canEdit($record):bool{
        return Access::isAdminOrSuper();
    }

    public static function canDelete($record):bool{
        return Access::isAdminOrSuper();
    }

    public static function canCreate():bool{
        return Access::isAdminOrSuper();
    }
}
