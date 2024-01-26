<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OMHDatasetsResource\Pages;
use App\Filament\Resources\OMHDatasetsResource\RelationManagers;
use App\Models\OMHDatasets;
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

class OMHDatasetsResource extends Resource
{
    protected static ?string $model = OMHDatasets::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationGroup = 'OMH Data';
    
    protected static ?string $label = 'DataSets';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextArea::make('description')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
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
            'index' => Pages\ListOMHDatasets::route('/'),
            'create' => Pages\CreateOMHDatasets::route('/create'),
            'edit' => Pages\EditOMHDatasets::route('/{record}/edit'),
        ];
    }    
}
