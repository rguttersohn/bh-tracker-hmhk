<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrevorResponseResource\Pages;
use App\Filament\Resources\TrevorResponseResource\RelationManagers;
use App\Models\TrevorResponse;
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

class TrevorResponseResource extends Resource
{
    protected static ?string $model = TrevorResponse::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationGroup = 'Trevor Project';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('year')->numeric(),
                TextInput::make('data')->numeric()->inputMode('decimal'),
                Select::make('trevor_question_id')->relationship('trevor_question','question'),
                Select::make('publication_status')->label('Status')->options([
                    'draft' => 'Draft',
                    'staging' => 'Staging',
                    'production' => 'Production'
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trevor_question.question')->label('Question'),
                TextColumn::make('year')->sortable(),
                TextColumn::make('data'),
                TextColumn::make('publication_status')->label('Status'),
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
            'index' => Pages\ListTrevorResponses::route('/'),
            'create' => Pages\CreateTrevorResponse::route('/create'),
            'edit' => Pages\EditTrevorResponse::route('/{record}/edit'),
        ];
    }    
}
