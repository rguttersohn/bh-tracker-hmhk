<?php

namespace App\Filament\Resources\OutPatientCapacityResource\Pages;

use App\Filament\Resources\OutPatientCapacityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOutPatientCapacity extends EditRecord
{
    protected static string $resource = OutPatientCapacityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
