<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GenderConstraintResource\Pages;
use App\Filament\Resources\GenderConstraintResource\RelationManagers;
use App\Models\GenderConstraint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class GenderConstraintResource extends Resource
{
    protected static ?string $model = GenderConstraint::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Youth Risky Behavior Survey';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('slug'),
                TextInput::make('label')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('slug'),
                TextColumn::make('label')
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
            'index' => Pages\ListGenderConstraints::route('/'),
            'create' => Pages\CreateGenderConstraint::route('/create'),
            'edit' => Pages\EditGenderConstraint::route('/{record}/edit'),
        ];
    }    
}
