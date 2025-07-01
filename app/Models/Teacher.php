<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{

    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'role' => 'array',
    ];
    protected $hidden = ['password'];




    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
