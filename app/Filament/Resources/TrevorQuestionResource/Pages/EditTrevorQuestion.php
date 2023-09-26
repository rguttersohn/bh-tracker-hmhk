<?php

namespace App\Filament\Resources\TrevorQuestionResource\Pages;

use App\Filament\Resources\TrevorQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrevorQuestion extends EditRecord
{
    protected static string $resource = TrevorQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
