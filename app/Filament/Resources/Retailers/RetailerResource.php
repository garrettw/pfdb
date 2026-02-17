<?php

namespace App\Filament\Resources\Retailers;

use App\Filament\Resources\Retailers\Pages\CreateRetailer;
use App\Filament\Resources\Retailers\Pages\EditRetailer;
use App\Filament\Resources\Retailers\Pages\ListRetailers;
use App\Filament\Resources\Retailers\Schemas\RetailerForm;
use App\Filament\Resources\Retailers\Tables\RetailersTable;
use App\Models\Retailer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RetailerResource extends Resource
{
    protected static ?string $model = Retailer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingStorefront;

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return RetailerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RetailersTable::configure($table);
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
            'index' => ListRetailers::route('/'),
            'create' => CreateRetailer::route('/create'),
            'edit' => EditRetailer::route('/{record}/edit'),
        ];
    }
}
