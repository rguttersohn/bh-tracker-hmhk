<?php

namespace App\Filament\Resources\RiskyQuestionResource\Pages;

use App\Filament\Resources\RiskyQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiskyQuestions extends ListRecords
{
    protected static string $resource = RiskyQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add Question'),
        ];
    }
}
