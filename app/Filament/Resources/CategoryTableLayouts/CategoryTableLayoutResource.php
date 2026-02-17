<?php

namespace App\Filament\Resources\CategoryTableLayouts;

use App\Filament\Resources\CategoryTableLayouts\Pages\CreateCategoryTableLayout;
use App\Filament\Resources\CategoryTableLayouts\Pages\EditCategoryTableLayout;
use App\Filament\Resources\CategoryTableLayouts\Pages\ListCategoryTableLayouts;
use App\Filament\Resources\CategoryTableLayouts\Schemas\CategoryTableLayoutForm;
use App\Filament\Resources\CategoryTableLayouts\Tables\CategoryTableLayoutsTable;
use App\Models\CategoryTableLayout;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CategoryTableLayoutResource extends Resource
{
    protected static ?string $model = CategoryTableLayout::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::TableCells;

    protected static ?string $navigationLabel = 'Table Layouts';

    protected static ?int $navigationSort = 4;

    protected static string|UnitEnum|null $navigationGroup = 'Categories';

    public static function form(Schema $schema): Schema
    {
        return CategoryTableLayoutForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoryTableLayoutsTable::configure($table);
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
            'index' => ListCategoryTableLayouts::route('/'),
            'create' => CreateCategoryTableLayout::route('/create'),
            'edit' => EditCategoryTableLayout::route('/{record}/edit'),
        ];
    }
}
