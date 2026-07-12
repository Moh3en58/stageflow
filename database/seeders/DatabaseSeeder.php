<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        User::updateOrCreate(
            ['email' => 'student@test.com'],
            [
                'name' => 'Student Test',
                'password' => $password,
                'role' => 'student',
            ]
        );

        User::updateOrCreate(
            ['email' => 'mentor@test.com'],
            [
                'name' => 'Mentor Test',
                'password' => $password,
                'role' => 'mentor',
            ]
        );

        User::updateOrCreate(
            ['email' => 'teacher@test.com'],
            [
                'name' => 'Teacher Test',
                'password' => $password,
                'role' => 'teacher',
            ]
        );

        User::updateOrCreate(
            ['email' => 'committee@test.com'],
            [
                'name' => 'Committee Test',
                'password' => $password,
                'role' => 'committee',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin Test',
                'password' => $password,
                'role' => 'admin',
            ]
        );
    }
}