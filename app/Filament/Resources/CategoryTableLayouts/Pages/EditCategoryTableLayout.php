<?php

namespace App\Filament\Resources\CategoryTableLayouts\Pages;

use App\Filament\Resources\CategoryTableLayouts\CategoryTableLayoutResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCategoryTableLayout extends EditRecord
{
    protected static string $resource = CategoryTableLayoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
