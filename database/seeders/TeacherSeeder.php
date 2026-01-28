<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{User,Teacher};

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher = Teacher::factory()
        ->for(User::factory()->state([
                'user_as' => 'teacher'
        ]))
        ->create();
    }
}
