<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // GET /api/services
    public function index()
    {
        return Service::query()->where('is_active', true)->orderBy('name')->get();
    }

    // GET /api/services/{id}
    public function show(int $id)
    {
        return Service::with(['department', 'employees'])->findOrFail($id);
    }

    // POST /api/admin/services
    public function store(Request $request)
    {
        $data = $request->validate([
            'department_id' => ['required','integer','exists:departments,id'],
            'name' => ['required','string','max:100'],
            'head_name' => ['nullable','string','max:255'],
            'extension' => ['nullable','string','max:10'],
            'is_active' => ['boolean'],
        ]);
        return Service::create($data);
    }

    // PUT/PATCH /api/admin/services/{id}
    public function update(Request $request, int $id)
    {
        $svc = Service::findOrFail($id);
        $data = $request->validate([
            'department_id' => ['sometimes','integer','exists:departments,id'],
            'name' => ['sometimes','string','max:100'],
            'head_name' => ['sometimes','nullable','string','max:255'],
            'extension' => ['sometimes','nullable','string','max:10'],
            'is_active' => ['sometimes','boolean'],
        ]);
        $svc->update($data);
        return $svc;
    }

    // DELETE /api/admin/services/{id}
    public function destroy(int $id)
    {
        $svc = Service::findOrFail($id);
        $svc->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
