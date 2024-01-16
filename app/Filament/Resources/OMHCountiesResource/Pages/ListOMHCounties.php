<?php

namespace App\Filament\Resources\OMHCountiesResource\Pages;

use App\Filament\Resources\OMHCountiesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListOMHCounties extends ListRecords
{
    protected static string $resource = OMHCountiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->label('Import Counties')
                ->fields([
                    ImportField::make('name')->required(),
                    ImportField::make('slug')->required(),
                ])
        ];
    }
}
