<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiskyResponseResource\Pages;
use App\Filament\Resources\RiskyResponseResource\RelationManagers;
use App\Models\RiskyResponse;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Actions\EditAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Support\Enums\ActionSize;

class RiskyResponseResource extends Resource
{
    protected static ?string $model = RiskyResponse::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $label = 'Youth Risky Behavior Responses';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Youth Risky Behavior Survey';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('year')->numeric(),
                TextInput::make('data')->numeric()->inputMode('decimal'),
                Select::make('risky_question_id')->relationship('risky_question','question'),
                Select::make('race_constraint_id')->relationship('race_constraint', 'label'),
                Select::make('sexual_id_constraint_id')->relationship('sexual_id_constraint', 'label'),
                Select::make('gender_constraint_id')->relationship('gender_constraint', 'label'),
                Select::make('publication_status')->label('Status')->options([
                    'draft' => 'Draft',
                    'staging' => 'Staging',
                    'production' => 'Production'
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('risky_question.question')->label('Question'),
                TextColumn::make('year')->sortable(),
                TextColumn::make('data'),
                TextColumn::make('race_constraint.label')->label('Race'),
                TextColumn::make('sexual_id_constraint.label')->label('Sexual ID'),
                TextColumn::make('gender_constraint.label')->label('Gender'),
                TextColumn::make('publication_status')->label('status')

            ])
            ->filters([
                SelectFilter::make('risky_question')
                    ->relationship('risky_question', 'question')
                    ->label('Question'),
                SelectFilter::make('race_constraint')
                    ->relationship('race_constraint', 'label')
                    ->label('Race'),
                SelectFilter::make('sexual_id_constraint')
                    ->relationship('sexual_id_constraint', 'label')
                    ->label('Sexual ID'),
            ])
            ->groups([
                Group::make('updated_at'),
                Group::make('risky_question.question')->label('Question')
                ])
            ->actions([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()->requiresConfirmation(),
                    ActionGroup::make([
                        Tables\Actions\Action::make('Draft')
                        ->action(function(RiskyResponse $record){
                            $record->publication_status = 'draft';
                            $record->save();
                        }),
                        Tables\Actions\Action::make('Staging')
                        ->action(function(RiskyResponse $record){
                            $record->publication_status = 'staging';
                            $record->save();
                        }),
                        Tables\Actions\Action::make('Production')
                        ->action(function(RiskyResponse $record){
                            $record->publication_status = 'production';
                            $record->save();
                        })
                    ])->button()->label('Change Status')->icon('heroicon-o-bars-3')->color('success')->size(ActionSize::Small)
                    
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
            'index' => Pages\ListRiskyResponse::route('/'),
            'create' => Pages\CreateRiskyResponse::route('/create'),
            'edit' => Pages\EditRiskyResponse::route('/{record}/edit'),
        ];
    }    
}
