<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    /** @use HasFactory<\Database\Factories\MaintenanceFactory> */
    use HasFactory;
    protected $with =['car','maintenance_type'];
    protected $fillable = ['date','kilometrage','maintenance_type_id','car_id'];
    public function car():BelongsTo{
        return $this->belongsTo(Car::class);
    }
    public function maintenance_type():BelongsTo{
        return $this->belongsTo(MaintenanceType::class);
    }

    public function date():Attribute{
        return Attribute::make(
            set: fn ($value) => Carbon::parse($value)->addDay()->format('Y-m-d')
        );
    }
}
