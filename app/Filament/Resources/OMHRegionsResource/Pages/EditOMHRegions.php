<?php

namespace App\Filament\Resources\OMHRegionsResource\Pages;

use App\Filament\Resources\OMHRegionsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOMHRegions extends EditRecord
{
    protected static string $resource = OMHRegionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
