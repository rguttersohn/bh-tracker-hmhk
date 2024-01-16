<?php

namespace App\Filament\Resources\OMHCountiesResource\Pages;

use App\Filament\Resources\OMHCountiesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOMHCounties extends EditRecord
{
    protected static string $resource = OMHCountiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
