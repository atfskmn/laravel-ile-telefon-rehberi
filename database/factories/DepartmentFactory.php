<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'code' => strtoupper($this->faker->lexify('DEPT??')),
            'description' => $this->faker->optional()->sentence(8),
            'manager_name' => $this->faker->name(),
            'location' => $this->faker->randomElement(['1. Kat','2. Kat','3. Kat','Merkez Bina']),
            'is_active' => true,
        ];
    }
}
