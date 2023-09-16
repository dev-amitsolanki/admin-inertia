<?php

namespace Database\Factories;

use App\Models\Payout;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'payout_id' => Payout::all()->random()->id,
            'amount_cents' => fake()->numberBetween(100,10000),
            'tax_type' => 'GST',
            'tax_percentage' => fake()->numberBetween(1,80),
            'currency' => fake()->randomElement(['AUD', 'USD']),
            'stripe_link' => fake()->url('http'), // password
            'paid' => fake()->randomElement([true,false]),
        ];
    }
}
