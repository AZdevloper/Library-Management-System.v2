<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Status;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'title' => fake()->name(),
            'author' => fake()->name(),
            'collection' => fake()->name(),
            'isbn' => fake()->name(),
            'pagesNumber' => fake()->numberBetween(1, 1000),
            'emplacement' => fake()->name(),
            'user_id' => User::factory(),
            'category_id' => mt_rand(1, 3),
            'status_id' => mt_rand(1, 3),

        ];
    }
}
