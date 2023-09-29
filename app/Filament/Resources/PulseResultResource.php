<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PulseResultResource\Pages;
use App\Filament\Resources\PulseResultResource\RelationManagers;
use App\Models\PulseResult;
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
use App\Models\PulseQuestion;
use App\Models\PulseResponse;

class PulseResultResource extends Resource
{
    protected static ?string $model = PulseResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationGroup = 'Pulse Survey MH Treatments';

    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('data')->numeric()->inputMode('decimals'),
                Select::make('date_range')->relationship('pulse_date_range','range'),
                Select::make('pulse_question_id')->label('Pulse Question')->options(PulseQuestion::all()->pluck('question', 'id')->toArray())
                    ->reactive(),
                Select::make('pulse_response_id')->options(
                    function(callable $get){
                        $question = PulseQuestion::find($get('pulse_question_id'));
                        if(!$question):
                            return [];
                        endif;
                        return $question->pulse_response->pluck('label', 'id');
                })->placeholder('Select a question to populate this field'),
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
                TextColumn::make('week'),
                TextColumn::make('date_range'),
                TextColumn::make('pulse_treatment_question.label'),
                TextColumn::make('pulse_treatment_response.label')
                //
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
            'index' => Pages\ListPulseResults::route('/'),
            'create' => Pages\CreatePulseResult::route('/create'),
            'edit' => Pages\EditPulseResult::route('/{record}/edit'),
        ];
    }    
}
