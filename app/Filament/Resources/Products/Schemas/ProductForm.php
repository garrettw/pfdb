<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use App\Models\Attribute;
use Filament\Infolists\Components\TextEntry;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product Information')
                    ->schema([
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn (callable $set) => $set('attributes', [])),
                        TextInput::make('name')
                            ->required()
                            ->placeholder('Product name'),
                        TextInput::make('brand')
                            ->placeholder('Brand/manufacturer'),
                        TextInput::make('model')
                            ->placeholder('Model number'),
                        Textarea::make('notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Retailer Links')
                    ->schema([
                        Repeater::make('retailerLinks')
                            ->relationship()
                            ->schema([
                                Select::make('retailer_id')
                                    ->label('Retailer')
                                    ->relationship('retailer', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->required()
                                            ->placeholder('e.g., Amazon, Best Buy'),
                                        TextInput::make('url')
                                            ->label('Retailer URL')
                                            ->url()
                                            ->placeholder('https://...'),
                                    ]),
                                TextInput::make('url')
                                    ->label('Product URL')
                                    ->url()
                                    ->required()
                                    ->placeholder('https://...'),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ]),

                Section::make('Test Metrics')
                    ->schema(function ($get, $record) {
                        $categoryId = $get('category_id');

                        if (!$categoryId) {
                            return [
                                TextEntry::make('select_category')
                                    ->state('Please select a category first to see available metrics.')
                                    ->columnSpanFull(),
                            ];
                        }

                        $attributes = Attribute::where('category_id', $categoryId)
                            ->orderBy('display_order')
                            ->get();

                        if ($attributes->isEmpty()) {
                            return [
                                TextEntry::make('no_attributes')
                                    ->state('No attributes defined for this category yet.')
                                    ->columnSpanFull(),
                            ];
                        }

                        $fields = [];
                        foreach ($attributes as $attribute) {
                            $value = $record ? $record->getEavAttribute($attribute->id) : null;

                            $field = TextInput::make("attribute_{$attribute->id}")
                                ->label($attribute->name . ($attribute->unit ? " ({$attribute->unit})" : ''))
                                ->default($value);

                            if ($attribute->type === 'numeric') {
                                $field->numeric();
                            }

                            $fields[] = $field;
                        }

                        return $fields;
                    })
                    ->visible(fn ($get) => $get('category_id') !== null),
            ]);
    }
}
