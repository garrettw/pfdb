<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected array $attributesToSave = [];

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $productAttributes = $this->record->productAttributes;
        foreach ($productAttributes as $productAttr) {
            $data["attribute_{$productAttr->attribute_id}"] = $productAttr->value;
        }
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
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

    protected function afterSave(): void
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
