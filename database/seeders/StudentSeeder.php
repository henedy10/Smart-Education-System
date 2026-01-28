<?php

namespace Database\Seeders;

use App\Models\{User,Student};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::factory()->for(User::factory()->state([
            'user_as' => 'student'
        ]))->create();
    }
}
