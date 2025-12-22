<?php

namespace App\Filament\Resources\DataBMNS;

use App\Filament\Resources\DataBMNS\Pages\CreateDataBMN;
use App\Filament\Resources\DataBMNS\Pages\EditDataBMN;
use App\Filament\Resources\DataBMNS\Pages\ListDataBMNS;
use App\Filament\Resources\DataBMNS\Schemas\DataBMNForm;
use App\Filament\Resources\DataBMNS\Tables\DataBMNSTable;
use App\Helpers\Access;
use App\Models\DataBmn;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DataBMNResource extends Resource
{
    protected static ?string $model = DataBMN::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArchiveBoxArrowDown;

    protected static ?string $recordTitleAttribute = 'Data BMN';

    protected static ?string $breadcrumb = 'Data BMN';
    
    protected static ?string $navigationLabel = 'Data BMN';
    public static function form(Schema $schema): Schema
    {
        return DataBMNForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DataBMNSTable::configure($table);
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
            'index' => ListDataBMNS::route('/'),
            'create' => CreateDataBMN::route('/create'),
            'edit' => EditDataBMN::route('/{record}/edit'),
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
