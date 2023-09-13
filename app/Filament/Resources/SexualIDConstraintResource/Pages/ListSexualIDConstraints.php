<?php

namespace App\Filament\Resources\SexualIDConstraintResource\Pages;

use App\Filament\Resources\SexualIDConstraintResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSexualIDConstraints extends ListRecords
{
    protected static string $resource = SexualIDConstraintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
