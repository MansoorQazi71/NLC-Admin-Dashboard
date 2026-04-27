<?php

namespace Database\Factories;

use App\Models\OfferRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OfferRequest>
 */
class OfferRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'status' => fake()->randomElement(['brouillon', 'envoyee', 'en_cours', 'terminee', 'annulee']),
            'description' => fake()->paragraph(),
        ];
    }
}
