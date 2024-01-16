<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OMHCountiesResource\Pages;
use App\Filament\Resources\OMHCountiesResource\RelationManagers;
use App\Models\OMHCounties;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class OMHCountiesResource extends Resource
{
    protected static ?string $model = OMHCounties::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationGroup = 'OMH Data';
    
    protected static ?string $label = 'Counties';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('slug')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
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
            'index' => Pages\ListOMHCounties::route('/'),
            'create' => Pages\CreateOMHCounties::route('/create'),
            'edit' => Pages\EditOMHCounties::route('/{record}/edit'),
        ];
    }    
}
