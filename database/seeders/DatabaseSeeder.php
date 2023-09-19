<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('race_constraints')->insert([
            [
                'slug' => 'total',
                'label' => 'Total'
            ],
            [
                'slug' => 'ai/an',
                'label' => 'AI/AN'
            ],
            [
                'slug' => 'asian',
                'label' => 'Asian'
            ],
            [
                'slug' => 'black',
                'label' => 'Black'
            ],
            [
                'slug' => 'hispanic',
                'label' => 'Hispanic'
            ],
            [
                'slug' => 'nhopi',
                'label' => 'NHOPI'
            ],
            [
                'slug' => 'white',
                'label' => 'White'
            ],
            [
                'slug' => 'multiple-race',
                'label' => 'Multiple Race'
            ],
        ]);

        DB::table('gender_constraints')->insert([
            [
                'slug' => 'total',
                'label' => 'Total'
            ],
            [
                'slug' => 'male',
                'label' => 'Male'
            ],
            [
                'slug' => 'female',
                'label' => 'Female'
            ],
            ]);

        DB::table('sexual_id_constraints')->insert([
            [
                'slug' => 'total',
                'label' => 'Total',
            ],
            [
                'slug' => 'heterosexual',
                'label' => 'Heterosexual (straight)',
            ],
            [
                'slug' => 'gay-lesbian',
                'label' => 'Gay or lesbian'
            ],
            [
                'slug' => 'bisexual',
                'label' => 'Bisexual'
            ],
            [
                'slug' => 'gay-lesbian-bisexual',
                'label' => 'Gay, lesbian, or bisexual'
            ],
            [
                'slug' => 'other',
                'label' => 'Other/Questioning'
            ]
            ]);

    }
}
