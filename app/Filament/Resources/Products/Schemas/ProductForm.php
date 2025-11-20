<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Get;
use Filament\Schemas\Schema;
use App\Models\Attribute;

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
                    
                Section::make('Test Metrics')
                    ->schema(function (Get $get, $record) {
                        $categoryId = $get('category_id');
                        
                        if (!$categoryId) {
                            return [
                                Placeholder::make('select_category')
                                    ->content('Please select a category first to see available metrics.')
                                    ->columnSpanFull(),
                            ];
                        }
                        
                        $attributes = Attribute::where('category_id', $categoryId)
                            ->orderBy('display_order')
                            ->get();
                            
                        if ($attributes->isEmpty()) {
                            return [
                                Placeholder::make('no_attributes')
                                    ->content('No attributes defined for this category yet.')
                                    ->columnSpanFull(),
                            ];
                        }
                        
                        $fields = [];
                        foreach ($attributes as $attribute) {
                            $value = $record ? $record->getAttributeValue($attribute->id) : null;
                            
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
                    ->visible(fn (Get $get) => $get('category_id') !== null),
            ]);
    }
}
