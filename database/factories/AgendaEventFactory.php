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
            'color' => fake()->randomElement(['#69727d', '#5cb85c', '#5bc0de', '#f0ad4e', '#d9534f']),
            'label' => fake()->randomElement(['Visite', 'Rappel', 'Contrat', 'Suivi']),
        ];
    }
}
