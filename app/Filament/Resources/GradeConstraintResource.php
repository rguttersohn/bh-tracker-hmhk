<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GradeConstraintResource\Pages;
use App\Filament\Resources\GradeConstraintResource\RelationManagers;
use App\Models\GradeConstraint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class GradeConstraintResource extends Resource
{
    protected static ?string $model = GradeConstraint::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?int $navigationSort = 6;

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
            'index' => Pages\ListGradeConstraints::route('/'),
            'create' => Pages\CreateGradeConstraint::route('/create'),
            'edit' => Pages\EditGradeConstraint::route('/{record}/edit'),
        ];
    }    
}
