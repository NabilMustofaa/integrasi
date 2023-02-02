<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\SalesTeam;
use App\Models\Survey;
use App\Models\SurveyCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        SurveyCategory::create([
            'name' => 'Kategori A',
            'created_by' => 1,
        ]);
        SurveyCategory::create([
            'name' => 'Kategori B',
            'created_by' => 1,
        ]);

        SalesTeam::create([
            'name' => 'Sales A',
            'phone' => '08123456789',
            'address' => 'Jl. A',
            'created_by' => 1,
        ]);


    }
}
