<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PulseWeekResource\Pages;
use App\Filament\Resources\PulseWeekResource\RelationManagers;
use App\Models\PulseWeek;
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


class PulseWeekResource extends Resource
{
    protected static ?string $model = PulseWeek::class;


    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';
    protected static ?string $navigationGroup = 'Pulse Survey MH Treatments';
    protected static ?int $navigationSort = 99;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('range'),
                TextInput::make('week')->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('week'),
                TextColumn::make('range')
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
            'index' => Pages\ListPulseWeeks::route('/'),
            'create' => Pages\CreatePulseWeek::route('/create'),
            'edit' => Pages\EditPulseWeek::route('/{record}/edit'),
        ];
    }    
}
