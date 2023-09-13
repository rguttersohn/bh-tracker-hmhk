<?php

namespace App\Filament\Resources\GenderConstraintResource\Pages;

use App\Filament\Resources\GenderConstraintResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGenderConstraint extends EditRecord
{
    protected static string $resource = GenderConstraintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
