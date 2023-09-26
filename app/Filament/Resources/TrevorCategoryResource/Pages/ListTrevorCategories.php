<?php

namespace App\Filament\Resources\TrevorCategoryResource\Pages;

use App\Filament\Resources\TrevorCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrevorCategories extends ListRecords
{
    protected static string $resource = TrevorCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
