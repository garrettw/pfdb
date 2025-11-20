<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $attributes = [];
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'attribute_')) {
                $attributes[$key] = $value;
                unset($data[$key]);
            }
        }
        $data['_attributes'] = $attributes;
        return $data;
    }
    
    protected function afterCreate(): void
    {
        $attributes = $this->data['_attributes'] ?? [];
        foreach ($attributes as $key => $value) {
            if (str_starts_with($key, 'attribute_') && $value !== null && $value !== '') {
                $attributeId = str_replace('attribute_', '', $key);
                $this->record->setEavAttribute($attributeId, $value);
            }
        }
    }
}
