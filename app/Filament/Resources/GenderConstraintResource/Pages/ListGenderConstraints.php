<?php

namespace App\Filament\Resources\GenderConstraintResource\Pages;

use App\Filament\Resources\GenderConstraintResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGenderConstraints extends ListRecords
{
    protected static string $resource = GenderConstraintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
