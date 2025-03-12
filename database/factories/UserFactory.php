<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'profile_picture' => $this->faker->imageUrl(),
            'bio' => $this->faker->sentence(),
            'theme' => $this->faker->randomElement(['light', 'dark']),
        ];
    }
    
    public function withLinks(int $count = 1): static
    {
        return $this->afterCreating(function (User $user) use ($count) {
            \App\Models\Link::factory()->count($count)->create(['user_id' => $user->id]);
        });
    }
}
