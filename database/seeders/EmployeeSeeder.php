<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        // First create test users (matching your actual users table structure)
        $users = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@test.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@test.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Mike Chen',
                'email' => 'mike.chen@test.com',
                'password' => Hash::make('password123'),
            ]
        ];

        $userIds = [];
        foreach ($users as $user) {
            $userId = DB::table('users')->insertGetId($user);
            $userIds[] = $userId;
        }

        // Then create employees linked to these users
        $employees = [
            [
                'username' => 'jsmith',
                'proper_name' => 'John Smith',
                'email' => 'john.smith@test.com',
                'phone' => '555-0101',
                'workshop' => 'Main Workshop',
                'role' => 'Senior Goldsmith',
                'access_level' => 'senior',
                'status' => 'active',
                'department' => 'Production',
                'valid_workshops' => json_encode(['Main Workshop']),
                'user_id' => $userIds[0]
            ],
            [
                'username' => 'sjohnson',
                'proper_name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@test.com',
                'phone' => '555-0102',
                'workshop' => 'Main Workshop',
                'role' => 'Jeweler',
                'access_level' => 'standard',
                'status' => 'active',
                'department' => 'Production',
                'valid_workshops' => json_encode(['Main Workshop']),
                'user_id' => $userIds[1]
            ],
            [
                'username' => 'mchen',
                'proper_name' => 'Mike Chen',
                'email' => 'mike.chen@test.com',
                'phone' => '555-0103',
                'workshop' => 'Main Workshop',
                'role' => 'Apprentice',
                'access_level' => 'junior',
                'status' => 'active',
                'department' => 'Production',
                'valid_workshops' => json_encode(['Main Workshop']),
                'user_id' => $userIds[2]
            ]
        ];

        foreach ($employees as $employee) {
            DB::table('employees')->insert($employee);
        }
    }
}