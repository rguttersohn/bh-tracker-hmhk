<?php

namespace App\Filament\Resources\PulseResponseResource\Pages;

use App\Filament\Resources\PulseResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPulseResponse extends EditRecord
{
    protected static string $resource = PulseResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
