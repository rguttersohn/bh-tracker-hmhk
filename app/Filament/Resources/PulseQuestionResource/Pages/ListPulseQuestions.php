<?php

namespace App\Filament\Resources\PulseQuestionResource\Pages;

use App\Filament\Resources\PulseQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPulseQuestions extends ListRecords
{
    protected static string $resource = PulseQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
