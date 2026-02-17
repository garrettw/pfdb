<?php

namespace App\Filament\Resources\CategoryTableLayouts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;

class CategoryTableLayoutForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live(),
                TextInput::make('name')
                    ->required()
                    ->placeholder('e.g., Weight vs Ranking'),
                RichEditor::make('content')
                    ->label('Table Description')
                    ->columnSpanFull()
                    ->hint('Describes what this table shows and what to look for'),
                TextInput::make('display_order')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Repeater::make('layoutColumns')
                    ->relationship()
                    ->schema([
                        Select::make('attribute_id')
                            ->label('Attribute')
                            ->relationship('attribute', 'name', fn ($query, $get) =>
                                $query->where('category_id', $get('../../category_id'))
                            )
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('label')
                            ->placeholder('Leave blank to use attribute name'),
                        TextInput::make('display_order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3)
                    ->defaultItems(0)
                    ->columnSpanFull()
                    ->label('Columns'),
            ]);
    }
}
