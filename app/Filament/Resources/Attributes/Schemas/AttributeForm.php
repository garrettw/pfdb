<?php

namespace App\Filament\Resources\Attributes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AttributeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('name')
                    ->required()
                    ->placeholder('e.g., Break Loose Torque'),
                TextInput::make('unit')
                    ->placeholder('e.g., ft-lbs, hours, $'),
                Select::make('type')
                    ->options([
                        'numeric' => 'Numeric',
                        'text' => 'Text',
                        'boolean' => 'Boolean',
                    ])
                    ->required()
                    ->default('text'),
                TextInput::make('display_order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Controls the order attributes appear in forms and tables'),
                Toggle::make('is_primary_metric')
                    ->label('Primary Metric')
                    ->helperText('Highlight this metric in comparisons')
                    ->default(false),
            ]);
    }
}
