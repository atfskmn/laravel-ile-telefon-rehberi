<?php

use Illuminate\Support\Facades\Route;
use App\Models\Employee;

Route::get('/employees', function () {
    return Employee::with(['department', 'service', 'position'])
        ->limit(10)
        ->get();
});
