<?php

namespace App\Filament\Resources\RaceConstraintResource\Pages;

use App\Filament\Resources\RaceConstraintResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRaceConstraints extends ListRecords
{
    protected static string $resource = RaceConstraintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
