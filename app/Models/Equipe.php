<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipe extends Model
{
    protected $fillable = ['mission_id','car_id','driver_id'];
    protected $with = ['car','driver','personnels'];
    public function mission():BelongsTo{
        return $this->belongsTo(Mission::class);
    }
    public function car():BelongsTo{
        return $this->belongsTo(Car::class);
    }
    public function personnels(): BelongsToMany
    {
        return $this->belongsToMany(Personnel::class, 'equipe_personnel', 'equipe_id');
    }
    public function driver():BelongsTo{
        return $this->belongsTo(Personnel::class, 'driver_id');
    }
}
