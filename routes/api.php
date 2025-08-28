<?php

use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Service;
use App\Models\Position;
use Illuminate\Http\Request;

// Employees: list with filters and pagination
Route::get('/employees', function (Request $request) {
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
});

// Employee detail
Route::get('/employees/{id}', function (int $id) {
    return Employee::with(['department', 'service', 'position'])->findOrFail($id);
});

// Departments
Route::get('/departments', function () {
    return Department::query()->where('is_active', true)->orderBy('name')->get();
});
Route::get('/departments/{id}/employees', function (int $id, Request $request) {
    $perPage = max(1, min(100, (int) $request->input('per_page', 20)));
    return Employee::with(['department', 'service', 'position'])
        ->where('department_id', $id)
        ->paginate($perPage)
        ->appends($request->query());
});

// Services
Route::get('/services', function () {
    return Service::query()->where('is_active', true)->orderBy('name')->get();
});
Route::get('/services/{id}/employees', function (int $id, Request $request) {
    $perPage = max(1, min(100, (int) $request->input('per_page', 20)));
    return Employee::with(['department', 'service', 'position'])
        ->where('service_id', $id)
        ->paginate($perPage)
        ->appends($request->query());
});

// Positions
Route::get('/positions', function () {
    return Position::query()->where('is_active', true)->orderBy('title')->get();
});

// Unified search endpoint
Route::get('/search', function (Request $request) {
    $request->merge(['q' => $request->input('q')]);
    return app()->handle(Request::create('/api/employees', 'GET', $request->query()));
});
