<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }
}
