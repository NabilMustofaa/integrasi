<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Branch;
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

        Branch::create([
            'name' => 'Cabang Utama',
            'phone' => '08123456789',
            'address' => 'Jl. A',
            'longitude' => 112.69627917727496,
            'latitude' => -7.353892398200614,
            'created_by' => 1,
        ]);

        Branch::create([
            'name' => 'Cabang A',
            'phone' => '08123456789',
            'address' => 'Jl. A',
            'longitude' => 112.69115506052464,
            'latitude' => -7.310802961476426,
            'created_by' => 1,
        ]);


    }
}
