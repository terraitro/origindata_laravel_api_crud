<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Project;
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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Employee::factory(10)->create();
        Project::factory(10)->create()->each(function ($project){
            $project->employees()->attach(rand(1, 10));
        });
        Company::factory(10)->create()->each(function ($company){
            $company->employees()->attach(rand(1, 10));
            $company->projects()->attach(rand(1, 10));
        });
    }
}
