<?php

namespace App\Filament\Resources\OMHDatasetsResource\Pages;

use App\Filament\Resources\OMHDatasetsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOMHDatasets extends ListRecords
{
    protected static string $resource = OMHDatasetsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
