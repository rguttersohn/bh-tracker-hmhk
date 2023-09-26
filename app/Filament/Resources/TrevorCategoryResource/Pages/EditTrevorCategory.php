<?php

namespace App\Filament\Resources\TrevorCategoryResource\Pages;

use App\Filament\Resources\TrevorCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrevorCategory extends EditRecord
{
    protected static string $resource = TrevorCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
