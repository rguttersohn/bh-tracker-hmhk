<?php

namespace App\Filament\Resources\OMHRegionsResource\Pages;

use App\Filament\Resources\OMHRegionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;


class ListOMHRegions extends ListRecords
{
    protected static string $resource = OMHRegionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->label('Import Regions')
                ->fields([
                    ImportField::make('name')->required(),
                    ImportField::make('slug')->required(),
                ])
        ];
    }
}
