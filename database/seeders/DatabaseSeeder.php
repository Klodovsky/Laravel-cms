<?php

namespace Database\Seeders;

use App\Models\Post;
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

        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \DB::table('users')->truncate();
        \DB::table('posts')->truncate();

        //creating 10 dummy users with 2 posts each
        User::factory(10)->has(Post::factory()->count(2))->create();
        //10 creating dummy posts
        Post::factory(10)->create();


        User::factory(10)->create()->each(function($user){
        $user->post()->save(Post::factory()->make());
        });
    }
}
