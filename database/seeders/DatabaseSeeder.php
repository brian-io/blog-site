<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{User, Blog, Category, Tag, Comment, NewsletterSubscriber};


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();
        Category::factory(5)->create();
        Tag::factory(10)->create();

        Blog::factory(20)->create()->each(function ($blog) {
            $blog->categories()->attach(Category::inRandomOrder()->take(2)->pluck('id'));
            $blog->tags()->attach(Tag::inRandomOrder()->take(3)->pluck('id'));
        });

        Comment::factory(40)->create();
        NewsletterSubscriber::factory(5)->create();

        // $this->call([
        //     BlogSeeder::class,
        //     UserSeeder::class,
        // ]);
    }
}
