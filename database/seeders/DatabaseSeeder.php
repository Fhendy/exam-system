<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin
        DB::table('users')->insert([
            'nis' => 'ADMIN001',
            'name' => 'Administrator',
            'email' => 'admin@exam.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'created_at' => now(),
        ]);

        // Sample Student
        DB::table('users')->insert([
            'nis' => '2024001',
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad@student.com',
            'password' => Hash::make('student123'),
            'role' => 'student',
            'is_active' => true,
            'created_at' => now(),
        ]);

        // Sample Exam
        DB::table('exams')->insert([
            'code' => '26JRRL',
            'title' => 'ASAS RPL',
            'description' => 'Ujian Akhir Semester ASAS Rekayasa Perangkat Lunak',
            'iframe_url' => 'https://forms.office.com/Pages/ResponsePage.aspx?id=EpcxM-1GrkuGemYeOm5dDmPe7q5rnQ5CvfTTEjuY1uZUNVNGWThIVkdIUjBVVEQzUFlJSjdPVE9BOS4u',
            'duration_minutes' => 90,
            'max_strikes' => 3,
            'passing_score' => 70,
            'is_active' => true,
            'created_at' => now(),
        ]);
    }
}