<?php

namespace App\Filament\Resources\CategoryTableLayouts\Pages;

use App\Filament\Resources\CategoryTableLayouts\CategoryTableLayoutResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategoryTableLayouts extends ListRecords
{
    protected static string $resource = CategoryTableLayoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
