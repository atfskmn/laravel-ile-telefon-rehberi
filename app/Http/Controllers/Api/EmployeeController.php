<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    // GET /api/employees
    public function index(Request $request)
    {
        $query = Employee::with(['department', 'service', 'position']);

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->integer('department_id'));
        }
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->integer('service_id'));
        }
        if ($request->filled('position_id')) {
            $query->where('position_id', $request->integer('position_id'));
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('first_name', 'like', "%$q%")
                    ->orWhere('last_name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('phone', 'like', "%$q%")
                    ->orWhere('mobile', 'like', "%$q%")
                    ->orWhere('extension', 'like', "%$q%")
                    ->orWhere('employee_number', 'like', "%$q%");
            });
        }

        $perPage = max(1, min(100, (int) $request->input('per_page', 20)));
        return $query->orderBy('last_name')->orderBy('first_name')
            ->paginate($perPage)
            ->appends($request->query());
    }

    // GET /api/employees/{id}
    public function show(int $id)
    {
        return Employee::with(['department', 'service', 'position'])->findOrFail($id);
    }

    // POST /api/admin/employees
    public function store(EmployeeStoreRequest $request)
    {
        $data = $request->validated();

        // Generate employee_number if empty
        if (empty($data['employee_number'] ?? null)) {
            $data['employee_number'] = 'EMP-'.strtoupper(bin2hex(random_bytes(3)));
        }

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/photos');
            $data['photo'] = basename($path);
        }

        $employee = Employee::create($data);
        return $employee->load(['department', 'service', 'position']);
    }

    // PUT/PATCH /api/admin/employees/{id}
    public function update(EmployeeUpdateRequest $request, int $id)
    {
        $employee = Employee::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            // delete old if exists
            if ($employee->photo) {
                Storage::delete('public/photos/'.$employee->photo);
            }
            $path = $request->file('photo')->store('public/photos');
            $data['photo'] = basename($path);
        }

        $employee->update($data);
        return $employee->load(['department', 'service', 'position']);
    }

    // DELETE /api/admin/employees/{id}
    public function destroy(int $id)
    {
        $employee = Employee::findOrFail($id);
        if ($employee->photo) {
            Storage::delete('public/photos/'.$employee->photo);
        }
        $employee->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
