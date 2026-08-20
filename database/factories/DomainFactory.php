<?php

namespace Database\Factories;

use App\Models\Domain;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Domain>
 */
class DomainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->domainName,
            'verification_token' => 'shelfcurator-verify-'.$this->faker->uuid,
            'is_verified' => false,
            'verified_at' => null,
            'ssl_status' => 'pending',
        ];
    }
}
