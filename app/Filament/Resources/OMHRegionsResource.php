<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OMHRegionsResource\Pages;
use App\Filament\Resources\OMHRegionsResource\RelationManagers;
use App\Models\OMHRegions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class OMHRegionsResource extends Resource
{
    protected static ?string $model = OMHRegions::class;
    
    protected static ?string $label = 'Regions';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationGroup = 'OMH Data';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
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
            'index' => Pages\ListOMHRegions::route('/'),
            'create' => Pages\CreateOMHRegions::route('/create'),
            'edit' => Pages\EditOMHRegions::route('/{record}/edit'),
        ];
    }    
}
