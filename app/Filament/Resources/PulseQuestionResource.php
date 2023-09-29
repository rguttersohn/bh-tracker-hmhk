<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PulseQuestionResource\Pages;
use App\Filament\Resources\PulseQuestionResource\RelationManagers;
use App\Models\PulseQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class PulseQuestionResource extends Resource
{
    protected static ?string $model = PulseQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    
    protected static ?string $navigationGroup = 'Pulse Survey MH Treatments';


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('question'),
            TextArea::make('explanation'),
            TextInput::make('source_url')->url(),
            TextArea::make('source_notes'),
            Select::make('publication_status')
                ->options([
                    'draft' => 'Draft',
                    'staging' => 'Staging',
                    'production' => 'Production',
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
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
            'index' => Pages\ListPulseQuestions::route('/'),
            'create' => Pages\CreatePulseQuestion::route('/create'),
            'edit' => Pages\EditPulseQuestion::route('/{record}/edit'),
        ];
    }    
}
