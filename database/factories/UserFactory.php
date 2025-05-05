<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Str::uuid(),  // Menetapkan id sebagai UUID
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // password default
            'role' => $this->faker->randomElement(['user', 'admin']),
        ];
    }

    /**
     * Indicate that the model's role is admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
            ];
        });
    }

    /**
     * Indicate that the model's role is applicant.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function applicant()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'user',
            ];
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
