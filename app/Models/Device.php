<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use SoftDeletes, HasFactory;

    public $timestamps = false;

    public function sensors(): BelongsToMany
    {
        return $this->belongsToMany(Sensor::class)->orderBy('name');
    }

    public function points(): HasMany
    {
        return $this->hasMany(Point::class);
    }
}
