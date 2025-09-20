<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sensor extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function devices(): BelongsToMany
    {
        return $this->belongsToMany(Device::class);
    }

    public function points(): HasMany
    {
        return $this->hasMany(Point::class);
    }
}
