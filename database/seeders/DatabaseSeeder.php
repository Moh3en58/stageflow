<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->createUser(
            name: 'Student Test',
            email: 'student@test.com',
            role: 'student'
        );

        $this->createUser(
            name: 'Mohsen Noorani',
            email: 'mo@test.com',
            role: 'student'
        );

        $this->createUser(
            name: 'Mentor Test',
            email: 'mentor@test.com',
            role: 'mentor'
        );

        $this->createUser(
            name: 'Teacher Test',
            email: 'teacher@test.com',
            role: 'teacher'
        );

        $this->createUser(
            name: 'Committee Test',
            email: 'committee@test.com',
            role: 'committee'
        );

        $this->createUser(
            name: 'Admin Test',
            email: 'admin@test.com',
            role: 'admin'
        );

        $this->command?->info('StageFlow test users created successfully.');
        $this->command?->info('Password for all test accounts: password');
    }

    private function createUser(
        string $name,
        string $email,
        string $role
    ): void {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password'),
            'role' => $role,
        ];

        if (Schema::hasColumn('users', 'email_verified_at')) {
            $data['email_verified_at'] = now();
        }

        if (Schema::hasColumn('users', 'updated_at')) {
            $data['updated_at'] = now();
        }

        $existingUser = DB::table('users')
            ->where('email', $email)
            ->first();

        if ($existingUser) {
            DB::table('users')
                ->where('email', $email)
                ->update($data);

            return;
        }

        if (Schema::hasColumn('users', 'created_at')) {
            $data['created_at'] = now();
        }

        DB::table('users')->insert($data);
    }
}