<?php

namespace App\Filament\Resources\GradeConstraintResource\Pages;

use App\Filament\Resources\GradeConstraintResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGradeConstraints extends ListRecords
{
    protected static string $resource = GradeConstraintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
