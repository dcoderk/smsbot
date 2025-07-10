<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Company; // Make sure to import the Company model

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'telephone' => fake()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'company_id' => Company::factory(), // Automatically create and link a Company
        ];
    }

    /**
     * A state for creating a Staff user.
     */
    public function staff(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'Staff',
            'title' => fake()->randomElement(['LPN', 'CNA']),
            // Creates a New York (USA) phone number
            'telephone' => fake()->randomElement(['212', '718', '917', '646']) . fake()->numerify('-###-####'),
        ]);
    }

    /**
     * A state for creating a Manager user.
     */
    public function manager(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'Manager',
            'title' => 'Hospital Manager', // Or set to null if managers have no title
        ]);
    }
}