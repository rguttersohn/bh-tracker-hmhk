<?php

namespace App\Filament\Resources\PulseQuestionResource\Pages;

use App\Filament\Resources\PulseQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPulseQuestion extends EditRecord
{
    protected static string $resource = PulseQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
