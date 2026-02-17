<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected array $attributesToSave = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extract and store attributes in a class property
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'attribute_')) {
                $this->attributesToSave[$key] = $value;
                unset($data[$key]);
            }
        }
        return $data;
    }

    protected function afterCreate(): void
    {
        // Save attributes using the stored data
        foreach ($this->attributesToSave as $key => $value) {
            // Allow any value including 0, but skip true nulls
            if (str_starts_with($key, 'attribute_') && $value !== null) {
                $attributeId = str_replace('attribute_', '', $key);
                $this->record->setEavAttribute($attributeId, $value);
            }
        }
    }
}
