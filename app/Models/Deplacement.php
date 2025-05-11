<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deplacement extends Model
{
    /** @use HasFactory<\Database\Factories\DeplacementFactory> */
    use HasFactory;
    protected $with = ['personnel'];
    protected $fillable = ['km_depart','km_arrivee','date','motif','car_id','personnel_id'];
    protected function date(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ? \Carbon\Carbon::parse($value)->addHour()->format('Y-m-d') : null,
        );
    }
    public function car():BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
    public function personnel():BelongsTo
    {
        return $this->belongsTo(Personnel::class);
    }
}
