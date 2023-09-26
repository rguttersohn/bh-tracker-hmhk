<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrevorCategoryResource\Pages;
use App\Filament\Resources\TrevorCategoryResource\RelationManagers;
use App\Models\TrevorCategory;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class TrevorCategoryResource extends Resource
{
    protected static ?string $model = TrevorCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    

    protected static ?string $navigationGroup = 'Trevor Project';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('label'),
                TextInput::make('slug'),
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
            'index' => Pages\ListTrevorCategories::route('/'),
            'create' => Pages\CreateTrevorCategory::route('/create'),
            'edit' => Pages\EditTrevorCategory::route('/{record}/edit'),
        ];
    }    
}
