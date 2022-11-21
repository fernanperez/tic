<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Internship;
use App\Models\Job;
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
        User::factory()
            ->has(Category::factory()->count(3)
                ->has(Blog::factory()))
            ->count(5)
            ->create();

            Job::factory()->count(40)->create();
            Internship::factory()->count(35)->create();
    }
}
