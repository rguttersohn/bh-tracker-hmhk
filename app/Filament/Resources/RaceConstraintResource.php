<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RaceConstraintResource\Pages;
use App\Filament\Resources\RaceConstraintResource\RelationManagers;
use App\Models\RaceConstraint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class RaceConstraintResource extends Resource
{
    protected static ?string $model = RaceConstraint::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Youth Risk Behavior Survey';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('slug'),
                TextInput::make('label'),
                TextArea::make('explanation')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('label'),
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListRaceConstraints::route('/'),
            'create' => Pages\CreateRaceConstraint::route('/create'),
            'edit' => Pages\EditRaceConstraint::route('/{record}/edit'),
        ];
    }    
}
