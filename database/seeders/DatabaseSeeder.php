<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Service;
use App\Models\Position;
use App\Models\Employee;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Departments
        $departments = Department::factory()->count(3)->create();

        // Positions
        $positions = Position::factory()->count(5)->create();

        // Services linked to departments
        $services = collect();
        foreach ($departments as $dept) {
            $services = $services->merge(Service::factory()->count(2)->create([
                'department_id' => $dept->id,
            ]));
        }

        // Employees
        for ($i = 0; $i < 10; $i++) {
            Employee::factory()->create([
                'department_id' => $departments->random()->id,
                'service_id' => $services->random()->id,
                'position_id' => $positions->random()->id,
            ]);
        }
    }
}
