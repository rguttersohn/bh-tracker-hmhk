<?php

namespace App\Filament\Resources\PulseDateRangeResource\Pages;

use App\Filament\Resources\PulseDateRangeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPulseDateRanges extends ListRecords
{
    protected static string $resource = PulseDateRangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
