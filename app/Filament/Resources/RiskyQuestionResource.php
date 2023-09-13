<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiskyQuestionResource\Pages;
use App\Filament\Resources\RiskyQuestionResource\RelationManagers;
use App\Models\RiskyQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Tables\Columns\TextColumn;


class RiskyQuestionResource extends Resource
{
    protected static ?string $model = RiskyQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $label = 'Youth Risky Behavior Questions';

    protected static ?string $navigationGroup = 'Youth Risky Behavior Survey';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('slug')->required(),
                TextInput::make('question'),
                TextArea::make('explanation'),
                TextInput::make('source_url')->url(),
                TextArea::make('source_notes')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('slug'),
                TextColumn::make('question'),
                TextColumn::make('publication_status')
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
            'index' => Pages\ListRiskyQuestions::route('/'),
            'create' => Pages\CreateRiskyQuestion::route('/create'),
            'edit' => Pages\EditRiskyQuestion::route('/{record}/edit'),
        ];
    }    
}
