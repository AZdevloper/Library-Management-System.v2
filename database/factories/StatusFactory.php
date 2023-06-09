<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['available', 'borrowed', 'processing'];
        $randomIndex = rand(0, count($statuses) - 1);

        return [
            'name' => $statuses[$randomIndex],
            
        ];
    }
}
