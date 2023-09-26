<?php

namespace App\Filament\Resources\TrevorResponseResource\Pages;

use App\Filament\Resources\TrevorResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrevorResponse extends EditRecord
{
    protected static string $resource = TrevorResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
