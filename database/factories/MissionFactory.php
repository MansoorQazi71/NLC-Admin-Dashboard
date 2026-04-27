<?php

namespace Database\Factories;

use App\Models\Mission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mission>
 */
class MissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'notes' => fake()->sentence(),
            'status' => fake()->randomElement(['assignee', 'personnelle', 'automatique', 'en_cours', 'en_retard', 'terminee_24h']),
            'deadline' => fake()->dateTimeBetween('-5 days', '+15 days')->format('Y-m-d'),
        ];
    }
}
