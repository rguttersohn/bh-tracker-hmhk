<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutPatientCapacityResource\Pages;
use App\Filament\Resources\OutPatientCapacityResource\RelationManagers;
use App\Models\OutPatientCapacity;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\ActionGroup;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Grouping\Group;

class OutPatientCapacityResource extends Resource
{
    protected static ?string $model = OutPatientCapacity::class;


    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationGroup = 'OMH Data';

    protected static ?int $navigationSort = 99;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('year')->numeric(),
                Select::make('region_id')->relationship('regions', 'name'),
                Select::make('county_id')->relationship('counties', 'name'),
                TextInput::make('capacity'),
                TextInput::make('rate_per_k')->numeric()->inputMode('decimal'),
                Select::make('publication_status')->options([
                    'draft' =>'Draft',
                    'staging' => 'Staging',
                    'production' => 'Production'
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year'),
                TextColumn::make('regions.name'),
                TextColumn::make('counties.name'),
                TextColumn::make('capacity'),
                TextColumn::make('rate_per_k'),
                TextColumn::make('publication_status')
            ])
            ->filters([
                SelectFilter::make('publication_status')
                ->label('Status')->options([
                    'draft' =>'Draft',
                    'staging' => 'Staging',
                    'production' => 'Production'
                ]),
                SelectFilter::make('county_id')->relationship('counties', 'name'),
                SelectFilter::make('region_id')->relationship('regions', 'name')

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
                ActionGroup::make([
                    Tables\Actions\Action::make('Draft')
                    ->action(function(OutPatientCapacity $record){
                        $record->publication_status = 'draft';
                        $record->save();
                    }),
                    Tables\Actions\Action::make('Staging')
                    ->action(function(OutPatientCapacity $record){
                        $record->publication_status = 'staging';
                        $record->save();
                    }),
                    Tables\Actions\Action::make('Production')
                    ->action(function(OutPatientCapacity $record){
                        $record->publication_status = 'production';
                        $record->save();
                    })
                ])->button()->label('Change Status')->icon('heroicon-o-bars-3')->color('success')->size(ActionSize::Small)

            ])
            ->groups([
                Group::make('updated_at'),
                Group::make('created_at'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkActionGroup::make([
                        Tables\Actions\BulkAction::make('Draft')
                        ->action(function($records){
                            $records->each(function($record){
                                $record->publication_status = 'draft';
                                $record->save();
                            });
                        })->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                        Tables\Actions\BulkAction::make('Staging')
                        ->action(function($records){
                            $records->each(function($record){
                                $record->publication_status = 'staging';
                                $record->save();
                            });
                        })->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                        Tables\Actions\BulkAction::make('Production')
                        ->action(function($records){
                            $records->each(function($record){
                                $record->publication_status = 'production';
                                $record->save();
                            });
                        })->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    ])->button()->label('Change Status')->icon('heroicon-o-bars-3')->color('success'),
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
            'index' => Pages\ListOutPatientCapacities::route('/'),
            'create' => Pages\CreateOutPatientCapacity::route('/create'),
            'edit' => Pages\EditOutPatientCapacity::route('/{record}/edit'),
        ];
    }    
}
