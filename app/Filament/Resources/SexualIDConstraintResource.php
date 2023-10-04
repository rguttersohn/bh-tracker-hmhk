<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SexualIDConstraintResource\Pages;
use App\Filament\Resources\SexualIDConstraintResource\RelationManagers;
use App\Models\SexualIDConstraint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class SexualIDConstraintResource extends Resource
{
    protected static ?string $model = SexualIDConstraint::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationLabel = 'Sexual Identity Constraints';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Youth Risk Behavior Survey';

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
            'index' => Pages\ListSexualIDConstraints::route('/'),
            'create' => Pages\CreateSexualIDConstraint::route('/create'),
            'edit' => Pages\EditSexualIDConstraint::route('/{record}/edit'),
        ];
    }    
}
