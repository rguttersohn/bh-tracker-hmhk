<?php

namespace App\Filament\Resources\RaceConstraintResource\Pages;

use App\Filament\Resources\RaceConstraintResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRaceConstraint extends EditRecord
{
    protected static string $resource = RaceConstraintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
