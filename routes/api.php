<?php

use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Service;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\PositionController;

// Employees: list and detail via controller
Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/employees/{id}', [EmployeeController::class, 'show']);

// Departments
Route::get('/departments', [DepartmentController::class, 'index']);
Route::get('/departments/{id}', [DepartmentController::class, 'show']);
Route::get('/departments/{id}/employees', function (int $id, Request $request) {
    $perPage = max(1, min(100, (int) $request->input('per_page', 20)));
    return Employee::with(['department', 'service', 'position'])
        ->where('department_id', $id)
        ->paginate($perPage)
        ->appends($request->query());
});

// Services
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{id}', [ServiceController::class, 'show']);
Route::get('/services/{id}/employees', function (int $id, Request $request) {
    $perPage = max(1, min(100, (int) $request->input('per_page', 20)));
    return Employee::with(['department', 'service', 'position'])
        ->where('service_id', $id)
        ->paginate($perPage)
        ->appends($request->query());
});

// Positions
Route::get('/positions', [PositionController::class, 'index']);
Route::get('/positions/{id}', [PositionController::class, 'show']);

// Admin CRUD routes
Route::prefix('admin')->group(function () {
    // Employees
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::match(['put', 'patch'], '/employees/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);

    // Departments
    Route::post('/departments', [DepartmentController::class, 'store']);
    Route::match(['put', 'patch'], '/departments/{id}', [DepartmentController::class, 'update']);
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy']);

    // Services
    Route::post('/services', [ServiceController::class, 'store']);
    Route::match(['put', 'patch'], '/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

    // Positions
    Route::post('/positions', [PositionController::class, 'store']);
    Route::match(['put', 'patch'], '/positions/{id}', [PositionController::class, 'update']);
    Route::delete('/positions/{id}', [PositionController::class, 'destroy']);
});

// Unified search endpoint
Route::get('/search', function (Request $request) {
    $request->merge(['q' => $request->input('q')]);
    return app()->handle(Request::create('/api/employees', 'GET', $request->query()));
});

