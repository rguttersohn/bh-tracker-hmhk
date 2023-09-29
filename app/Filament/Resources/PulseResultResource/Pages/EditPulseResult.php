<?php

namespace App\Filament\Resources\PulseResultResource\Pages;

use App\Filament\Resources\PulseResultResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPulseResult extends EditRecord
{
    protected static string $resource = PulseResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
