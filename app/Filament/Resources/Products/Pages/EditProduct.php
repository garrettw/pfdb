<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

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
    
    protected function afterSave(): void
    {
        $attributes = $this->data['_attributes'] ?? [];
        foreach ($attributes as $key => $value) {
            if (str_starts_with($key, 'attribute_')) {
                $attributeId = str_replace('attribute_', '', $key);
                $this->record->setEavAttribute($attributeId, $value);
            }
        }
    }
}
