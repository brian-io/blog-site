<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
        ->count(5)
        ->hasBlogs(2)
        ->create();

        DB::table('blogs')->insert([
            'user_id'=> 1,
            'title' => 'The Singularity',
            'content'=> 'The concept of singularity was brought about by Roger Penrose, a physicts from MIT. '
        ]);

    }
}


