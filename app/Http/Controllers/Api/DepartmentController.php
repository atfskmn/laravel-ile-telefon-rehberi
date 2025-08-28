<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // GET /api/departments
    public function index()
    {
        return Department::query()->where('is_active', true)->orderBy('name')->get();
    }

    // GET /api/departments/{id}
    public function show(int $id)
    {
        return Department::with(['services', 'employees'])->findOrFail($id);
    }

    // POST /api/admin/departments
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'code' => ['nullable','string','max:10'],
            'description' => ['nullable','string'],
            'manager_name' => ['nullable','string','max:255'],
            'location' => ['nullable','string','max:255'],
            'is_active' => ['boolean'],
        ]);
        return Department::create($data);
    }

    // PUT/PATCH /api/admin/departments/{id}
    public function update(Request $request, int $id)
    {
        $dept = Department::findOrFail($id);
        $data = $request->validate([
            'name' => ['sometimes','string','max:100'],
            'code' => ['sometimes','nullable','string','max:10'],
            'description' => ['sometimes','nullable','string'],
            'manager_name' => ['sometimes','nullable','string','max:255'],
            'location' => ['sometimes','nullable','string','max:255'],
            'is_active' => ['sometimes','boolean'],
        ]);
        $dept->update($data);
        return $dept;
    }

    // DELETE /api/admin/departments/{id}
    public function destroy(int $id)
    {
        $dept = Department::findOrFail($id);
        $dept->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
