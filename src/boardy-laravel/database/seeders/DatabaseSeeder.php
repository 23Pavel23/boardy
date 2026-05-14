<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@boardy.local',
            'password' => bcrypt('password'),
        ]);

        $users = User::factory()->count(4)->create();
        Post::factory()->count(10)->create();
        Comment::factory()->count(25)->create();
    }
}
