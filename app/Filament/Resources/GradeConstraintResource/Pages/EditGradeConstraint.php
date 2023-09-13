<?php

namespace App\Filament\Resources\GradeConstraintResource\Pages;

use App\Filament\Resources\GradeConstraintResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGradeConstraint extends EditRecord
{
    protected static string $resource = GradeConstraintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
