<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PulseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pulse_questions')->insert([
            [
             'question' => 'Did the children who need mental health treatment receive it?',
            'publication_status' => 'staging'
            ],
            [
             'question' => 'How difficult was it to get mental health treatment for the children?',
             'publication_status' => 'staging'
            ]
            ]);
 
         DB::table('pulse_responses')->insert([
             [
                 'label' => 'Not Difficult',
                 'slug' => 'not',
                 'pulse_question_id' => 2
             ],
             [
                 'label' => 'Somewhat Difficult',
                 'slug' => 'somewhat',
                 'pulse_question_id' => 2
             ],
             [
                 'label' => 'Very Difficult',
                 'slug' => 'very',
                 'pulse_question_id' => 2
             ],
             [
                 'label' => 'Unable to Get Treatment',
                 'slug' => 'unable',
                 'pulse_question_id' => 2
             ],
             [
                 'label' => 'Did not try to get treatment',
                 'slug' => 'not-try',
                 'pulse_question_id' => 2
             ],
             [
                 'label' => 'All children who needed treatment received it',
                 'slug' => 'all',
                 'pulse_question_id' => 1
             ],
             [
                 'label' => 'Only some children who needed treatment received it',
                 'slug' => 'some',
                 'pulse_question_id' => 1
             ],
             [
                 'label' => 'None of the children who needed treatment received it',
                 'slug' => 'none',
                 'pulse_question_id' => 1
             ],
         ]);
         DB::table('pulse_date_ranges')->insert([
             [
                 'range' => '6/7 - 6/19',
                 'week' => 58,
             ], 
             [
                 'range' => '6/28 - 7/10',
                 'week' => 59,
             ], 
             [
                 'range' => '7/27 - 8/08',
                 'week' => 60,
             ], 
             [
                 'range' => '8/23 - 9/4',
                 'week' => 61,
             ],     
         ]);
    }
}
