<?php

namespace Database\Seeders;

use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Database\Factories\Helpers\FactoryHelper;
use \App\Models\Post;
use \App\Models\User;
// use \App\Models\Comment;

class PostSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $this->truncate('posts');
        $this->truncate('post_user');

        $posts = Post::factory(3)
                // ->has(Comment::factory(3), 'comments')
                ->untitled()
                ->create();

        $posts->each(function(Post $post){
            $post->users()->sync([FactoryHelper::getRandomModelId(User::class)]);
        });

        $this->enableForeignKeys();
    }
}
