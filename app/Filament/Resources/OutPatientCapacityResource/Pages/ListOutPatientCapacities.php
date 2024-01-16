<?php

namespace App\Filament\Resources\OutPatientCapacityResource\Pages;

use App\Filament\Resources\OutPatientCapacityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use Illuminate\Support\Facades\DB;

class ListOutPatientCapacities extends ListRecords
{
    protected static string $resource = OutPatientCapacityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->label('Import Capacity Data')
                ->fields([
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
