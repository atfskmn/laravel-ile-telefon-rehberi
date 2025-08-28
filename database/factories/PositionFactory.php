<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement(['Uzman','Kıdemli Uzman','Şef','Müdür','Direktör']),
            'level' => $this->faker->numberBetween(1,10),
            'description' => $this->faker->optional()->sentence(6),
            'is_active' => true,
        ];
    }
}
