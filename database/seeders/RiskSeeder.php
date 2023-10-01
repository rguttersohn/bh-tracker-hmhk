<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiskSeeder extends Seeder
{
    /**
     * Seed the yrbss tables.
     */
    public function run(): void
    {
        
        DB::table('race_constraints')->insert([
            [
                'slug' => 'all',
                'label' => 'All'
            ],
            [
                'slug' => 'ai/an',
                'label' => 'American Indian or Alaska Native'
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
                'label' => 'Native Hawaiian/Other Pacific Islander'
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
                'slug' => 'all',
                'label' => 'All'
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
                'slug' => 'all',
                'label' => 'All',
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


        DB::table('risky_questions')->insert([
            [
                'question' => 'Felt Sad or Hopeless',
                'explanation' => 'Percent of students who said they felt sad or hopeless almost every day for 2 or more weeks in a row so that they stopped doing some usual activities, during the 12 months before the survey.',
                'publication_status' => 'staging'
            ],
            [
                'question' => 'Seriously Considered Attempting Suicide',
                'explanation' => 'Percent of students who seriously considered attempting suicide during the 12 months before the survey.',
                'publication_status' => 'staging'
            ],
            [
                'question' => 'Actually Attempted Suicide',
                'explanation' => 'Percent of students who actually attempted suicide
                one or more times during the 12 months before the survey.',
                'publication_status' => 'staging'
            ],
        ]);


    }
}
