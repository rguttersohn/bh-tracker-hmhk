<?php

namespace App\Filament\Resources\OMHDataResource\Pages;

use App\Filament\Resources\OMHDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use Illuminate\Support\Facades\DB;

class ListOMHData extends ListRecords
{
    protected static string $resource = OMHDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->label('Import OMH Data')
                ->fields([
                    ImportField::make('dataset_id')
                        ->required()
                        ->label('Dataset Name')
                        ->mutateBeforeCreate(function($value){
                            $dataset = DB::table('omh_datasets')
                                ->select('id')
                                ->where('name','=', $value)
                                ->first();
                            if($dataset?->id):
                                return $dataset->id;
                            else:
                                return $value;
                            endif;
                        }),
                    ImportField::make('year')->required(),
                    ImportField::make('region_id')
                        ->required()
                        ->label('Region')
                        ->mutateBeforeCreate(function($value){
                        
                        $region = DB::table('omh_regions')
                                    ->select('id')
                                    ->where('name','=', $value)
                                    ->first();

                        if($region?->id):
                            return $region->id;
                        else:
                            return $value;
                        endif;
                    }),
                    ImportField::make('county_id')
                        ->required()
                        ->label('County')
                        ->mutateBeforeCreate(function($value){
                        $county = DB::table('omh_counties')
                                    ->select('id')
                                    ->where('name', '=', $value)
                                    ->first();

                            if($county?->id):
                                return $county->id;
                            else:
                                return $value;
                            endif;
                    }),
                    ImportField::make('capacity')->required(),
                    ImportField::make('rate_per_k')->required()->label('Rate Per 100K'),
                ])
        ];
    }
}
