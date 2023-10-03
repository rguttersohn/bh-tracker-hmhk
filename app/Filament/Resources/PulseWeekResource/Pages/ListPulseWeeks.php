<?php

namespace App\Filament\Resources\PulseWeekResource\Pages;

use App\Filament\Resources\PulseWeekResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPulseWeeks extends ListRecords
{
    protected static string $resource = PulseWeekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
