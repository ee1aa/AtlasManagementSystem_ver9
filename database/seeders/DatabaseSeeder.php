<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Users\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->count(5)->create();
        $this->call([SubjectsTableSeeder::class]);
        $this->call([MainCategoriesSeeder::class]);
        $this->call([SubCategoriesSeeder::class]);
        $this->call(ReserveTestSeeder::class);
    }
}
