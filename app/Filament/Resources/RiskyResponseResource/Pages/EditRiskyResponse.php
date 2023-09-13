<?php

namespace App\Filament\Resources\RiskyResponseResource\Pages;

use App\Filament\Resources\RiskyResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiskyResponse extends EditRecord
{
    protected static string $resource = RiskyResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
