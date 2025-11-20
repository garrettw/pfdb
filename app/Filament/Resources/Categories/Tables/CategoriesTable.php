<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Filament\Resources\Attributes\Pages\ListAttributes;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('attributes_count')
                    ->counts('attributes')
                    ->label('Attributes')
                    ->sortable()
                    ->url(fn (Category $record): string => ListAttributes::getUrl(['filters[category][value]' => $record->id])),
                TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Products')
                    ->sortable()
                    ->url(fn (Category $record): string => ListProducts::getUrl(['filters[category][value]' => $record->id])),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
