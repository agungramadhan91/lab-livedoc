<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Helpers\FactoryHelper;
use App\Models\Post;
use App\Models\User;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => [],
            'user_id' => FactoryHelper::getRandomModelId(User::class),
            'post_id' => FactoryHelper::getRandomModelId(Post::class),
        ];
    }
}
