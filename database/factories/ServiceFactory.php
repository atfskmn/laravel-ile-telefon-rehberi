<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'department_id' => Department::factory(),
            'name' => $this->faker->jobTitle(),
            'code' => strtoupper($this->faker->lexify('SRV??')),
            'description' => $this->faker->optional()->sentence(8),
            'head_name' => $this->faker->name(),
            'extension' => (string)$this->faker->numberBetween(1000, 9999),
            'is_active' => true,
        ];
    }
}
