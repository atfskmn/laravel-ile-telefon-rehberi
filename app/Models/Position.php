<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'level', 'description', 'is_active',
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
