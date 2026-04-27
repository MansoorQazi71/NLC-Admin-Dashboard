<?php

namespace Database\Factories;

use App\Models\AgendaEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AgendaEvent>
 */
class AgendaEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(2),
            'event_date' => fake()->dateTimeBetween('-10 days', '+20 days')->format('Y-m-d'),
            'color' => fake()->randomElement(['#4F46E5', '#0891B2', '#DC2626', '#059669']),
            'label' => fake()->randomElement(['Visite', 'Rappel', 'Contrat', 'Suivi']),
        ];
    }
}
