<?php

namespace App\Filament\Resources\PulseDateRangeResource\Pages;

use App\Filament\Resources\PulseDateRangeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPulseDateRange extends EditRecord
{
    protected static string $resource = PulseDateRangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
