<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;
    protected $with = ['car_brand','car_type','fuel'];
    protected $fillable = ['model','plate','kilometrage','tank_capacity','motor','n_chassis','car_brand_id','car_type_id','fuel_id'];
    public function car_brand(): BelongsTo{
        return $this->belongsTo(CarBrand::class);
    }
    public function car_type(): BelongsTo{
        return $this->belongsTo(CarType::class);
    }
    public function fuel(): BelongsTo{
        return $this->belongsTo(Fuel::class);
    }
    public function papers(): BelongsToMany{
        return $this->belongsToMany(Paper::class,'car_paper','car_id','paper_id')->withPivot(['file','date'])->withTimestamps();
    }

    public function maintenance_types(): BelongsToMany{
        return $this->belongsToMany(MaintenanceType::class,'car_maintenance_type','car_id','maintenance_type_id')->withPivot(['date','km','next_km','observation']);
    }

}
