<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dotation extends Model
{
    /** @use HasFactory<\Database\Factories\DotationFactory> */
    use HasFactory;
    protected $fillable = ['label','value','car_id','personnel_id','mission_id','km'];
    protected $with = ['car','personnel'];
    public function car(): BelongsTo{
        return $this->belongsTo(Car::class);
    }
    public function personnel(): BelongsTo{
        return $this->belongsTo(Personnel::class);
    }
}
