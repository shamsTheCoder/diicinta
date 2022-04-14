<?php

namespace Database\Seeders;

use App\Models\Article;
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
        //\App\Models\User::factory(10)->create();
        Article::truncate();
        $faker = \Faker\Factory::create();
        for ($i=0; $i < 50; $i++) { 
            Article::create([
                'title' => $faker->sentence,
                'content' => $faker->paragraph,
                'author' => $faker->name,
                'category' => $faker->text,
                'published_on' => $faker->date(),
            ]);
        }
        
    }
}
