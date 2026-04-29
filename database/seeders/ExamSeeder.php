<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamSeeder extends Seeder
{
    public function run()
    {
        DB::table('exams')->insert([
            'code' => '26JRRL',
            'name' => 'ASAS RPL',
            'office_url' => 'https://forms.office.com/Pages/ResponsePage.aspx?id=EpcxM-1GrkuGemYeOm5dDmPe7q5rnQ5CvfTTEjuY1uZUNVNGWThIVkdIUjBVVEQzUFlJSjdPVE9BOS4u',
            'duration_minutes' => 90,
            'max_strikes' => 3,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}