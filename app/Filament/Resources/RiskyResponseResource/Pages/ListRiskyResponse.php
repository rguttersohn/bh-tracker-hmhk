<?php

namespace App\Filament\Resources\RiskyResponseResource\Pages;

use App\Filament\Resources\RiskyResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListRiskyResponse extends ListRecords
{
    protected static string $resource = RiskyResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add Response'),
            ImportAction::make()
                ->label('Import Responses')
                ->fields([
                    ImportField::make('year')->required(),
                    ImportField::make('data')->required(),
                    ImportField::make('risky_question_id')->required(),
                    ImportField::make('race_constraint_id')->required(),
                    ImportField::make('sexual_id_constraint_id')->required(),
                    ImportField::make('gender_constraint_id')->required(),
                ])

        ];
    }
}
