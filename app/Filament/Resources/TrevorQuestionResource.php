<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrevorQuestionResource\Pages;
use App\Filament\Resources\TrevorQuestionResource\RelationManagers;
use App\Models\TrevorQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class TrevorQuestionResource extends Resource
{
    protected static ?string $model = TrevorQuestion::class;


    protected static ?string $navigationGroup = 'Trevor Project';
    
    protected static ?string $navigationIcon = 'heroicon-o-folder';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('question'),
                TextInput::make('explanation'),
                TextInput::make('source_url'),
                TextInput::make('source_notes'),
                Select::make('publication_status')->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'staging' => 'Staging',
                        'production' => 'Production'
                    ]),
                Select::make('trevor_category_id')
                    ->relationship('trevor_category', 'label')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('question'),
                TextColumn::make('publication_status')->label('Status'),
                TextColumn::make('trevor_category.label')
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
            'index' => Pages\ListTrevorQuestions::route('/'),
            'create' => Pages\CreateTrevorQuestion::route('/create'),
            'edit' => Pages\EditTrevorQuestion::route('/{record}/edit'),
        ];
    }    
}
