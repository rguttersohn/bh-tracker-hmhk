<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PulseResponseResource\Pages;
use App\Filament\Resources\PulseResponseResource\RelationManagers;
use App\Models\PulseResponse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;

class PulseResponseResource extends Resource
{
    protected static ?string $model = PulseResponse::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationGroup = 'Pulse Survey MH Treatments';

    protected static ?int $navigationSort = 98;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('label'),
                TextInput::make('slug'),
                Select::make('pulse_question_id')->relationship('pulse_question', 'question'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('label'),
                TextColumn::make('slug')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPulseResponses::route('/'),
            'create' => Pages\CreatePulseResponse::route('/create'),
            'edit' => Pages\EditPulseResponse::route('/{record}/edit'),
        ];
    }    
}
