<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

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
        $faker = Faker::create();

        $categories = [
            [
                'title' => 'tutorial',
                'slug' => Str::slug('tutorial'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'news',
                'slug' => Str::slug('news'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'info',
                'slug' => Str::slug('info'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'tips & trik',
                'slug' => Str::slug('tips & trik'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $user_admin = [
            'avatar' => $faker->imageUrl(100, 100),
            'is_admin' => 1,
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Category::insert($categories);
        User::insert($user_admin);

        for ($i = 0; $i < 10; $i++) {
            Article::insert([
                'user_id' => 1,
                'category_id' => rand(1, 4),
                'status' => 'draft',
                'slug' => Str::slug($faker->sentence(3)),
                'title' => $faker->sentence(3),
                'thumbnail' => $faker->imageUrl(400, 200),
                'content' => $faker->paragraph(10),
                'view_count' => rand(1, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
