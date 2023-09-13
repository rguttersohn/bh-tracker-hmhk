<?php

namespace App\Filament\Resources\SexualIDConstraintResource\Pages;

use App\Filament\Resources\SexualIDConstraintResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSexualIDConstraint extends EditRecord
{
    protected static string $resource = SexualIDConstraintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
