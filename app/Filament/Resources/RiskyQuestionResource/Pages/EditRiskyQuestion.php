<?php

namespace App\Filament\Resources\RiskyQuestionResource\Pages;

use App\Filament\Resources\RiskyQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiskyQuestion extends EditRecord
{
    protected static string $resource = RiskyQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
