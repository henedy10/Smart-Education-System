<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher = Teacher::factory()
            ->for(User::factory()->state([
                'user_as' => 'teacher',
            ]))
            ->create();
    }
}
