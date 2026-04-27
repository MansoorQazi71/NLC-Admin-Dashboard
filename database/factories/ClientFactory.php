<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'type' => fake()->randomElement(['client', 'prospect', 'professionnel']),
            'status' => fake()->randomElement(['actif', 'inactif']),
            'notes' => fake()->sentence(),
        ];
    }
}
