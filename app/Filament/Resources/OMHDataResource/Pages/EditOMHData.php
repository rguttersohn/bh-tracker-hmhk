<?php

namespace App\Filament\Resources\OMHDataResource\Pages;

use App\Filament\Resources\OMHDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOMHData extends EditRecord
{
    protected static string $resource = OMHDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
