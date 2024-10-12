<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Job;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::insert(
            [
                [
                    'name' => 'mazhar',
                    'email' => 'mazhar@gmail.com',
                    'password' => bcrypt('password')
                ],
                [
                    'name' => 'naved',
                    'email' => 'naved@gmail.com',
                    'password' => bcrypt('password')
                ],
                [
                    'name' => 'muskan',
                    'email' => 'muskan@gmail.com',
                    'password' => bcrypt('password')
                ],
                [
                    'name' => 'tajammul',
                    'email' => 'tajammul@gmail.com',
                    'password' => bcrypt('password')
                ],
                [
                    'name' => 'amir',
                    'email' => 'amir@gmail.com',
                    'password' => bcrypt('password')
                ],
                [
                    'name' => 'ahad',
                    'email' => 'ahad@gmail.com',
                    'password' => bcrypt('password')
                ]
            ]
        );

        JobType::insert(
            [
                ['name' => 'Full Time'],
                ['name' => 'Part Time'],
                ['name' => 'Remote'],
                ['name' => 'Contract'],
                ['name' => 'freelance']
            ]
        );

        Category::insert(
            [
                ['name' => 'Engineering'],
                ['name' => 'Account'],
                ['name' => 'Fashion Designing'],
                ['name' => 'Information Technology']
            ]
        );

        // Job::factory(25)->create();

    }
}
