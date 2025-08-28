<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    // GET /api/positions
    public function index()
    {
        return Position::query()->where('is_active', true)->orderBy('title')->get();
    }

    // GET /api/positions/{id}
    public function show(int $id)
    {
        return Position::with(['employees'])->findOrFail($id);
    }

    // POST /api/admin/positions
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:100'],
            'level' => ['nullable','string','max:50'],
            'description' => ['nullable','string'],
            'is_active' => ['boolean'],
        ]);
        return Position::create($data);
    }

    // PUT/PATCH /api/admin/positions/{id}
    public function update(Request $request, int $id)
    {
        $pos = Position::findOrFail($id);
        $data = $request->validate([
            'title' => ['sometimes','string','max:100'],
            'level' => ['sometimes','nullable','string','max:50'],
            'description' => ['sometimes','nullable','string'],
            'is_active' => ['sometimes','boolean'],
        ]);
        $pos->update($data);
        return $pos;
    }

    // DELETE /api/admin/positions/{id}
    public function destroy(int $id)
    {
        $pos = Position::findOrFail($id);
        $pos->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
