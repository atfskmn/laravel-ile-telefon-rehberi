<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        $first = $this->faker->firstName();
        $last = $this->faker->lastName();
        return [
            'department_id' => Department::factory(),
            'service_id' => Service::factory(),
            'position_id' => Position::factory(),
            'employee_number' => strtoupper($this->faker->bothify('EMP-####')),
            'first_name' => $first,
            'last_name' => $last,
            'email' => strtolower($first.'.'.$last).'@example.com',
            'phone' => '0212 '.$this->faker->numberBetween(200,999).' '.$this->faker->numberBetween(1000,9999),
            'mobile' => '05'.$this->faker->numberBetween(30,59).' '.$this->faker->numberBetween(200,999).' '.$this->faker->numberBetween(1000,9999),
            'extension' => (string)$this->faker->numberBetween(1000,9999),
            'office_location' => $this->faker->randomElement(['A Blok 2. Kat','B Blok 3. Kat','Merkez Bina 1. Kat']),
            'hire_date' => $this->faker->date(),
            'is_active' => true,
            'photo' => null,
        ];
    }
}
