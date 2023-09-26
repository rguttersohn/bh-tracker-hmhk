<?php

namespace App\Filament\Resources\TrevorResponseResource\Pages;

use App\Filament\Resources\TrevorResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrevorResponses extends ListRecords
{
    protected static string $resource = TrevorResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
