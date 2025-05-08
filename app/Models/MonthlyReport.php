<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlyReport extends Model
{
    /** @use HasFactory<\Database\Factories\MonthlyReportFactory> */
    use HasFactory;

    protected $fillable = ['car_id', 'dotation_id', 'maintenance_id', 'date'];
    protected $with = ['maintenance', 'dotation'];

    public function dotation(): BelongsTo
    {
        return $this->belongsTo(Dotation::class);
    }

    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function date():Attribute
    {
        return Attribute::make(get:fn($value)=>Carbon::parse($value)->format('d/m/Y'));
    }
}
