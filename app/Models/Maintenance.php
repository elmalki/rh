<?php

namespace App\Models;

use Carbon\Carbon;
use Dompdf\Css\Content\Attr;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Maintenance extends Model
{
    /** @use HasFactory<\Database\Factories\MaintenanceFactory> */
    use HasFactory;
    protected $with =['car','maintenance_types'];
    protected $appends = ['operations'];
    protected $fillable = ['date','kilometrage','montant','car_id','observation','n_bon'];

    public function operations():Attribute
    {
        return Attribute::make(get:fn()=>$this->maintenance_types()->pluck('label'));
    }
    public function maintenance_types():BelongsToMany
    {
        return $this->belongsToMany(MaintenanceType::class, 'car_maintenance_type', 'maintenance_id', 'maintenance_type_id')->withPivot(['montant','observation']);
    }
    public function car():BelongsTo{
        return $this->belongsTo(Car::class);
    }


    public function date():Attribute{
        return Attribute::make(
            set: fn ($value) => Carbon::parse($value)->addDay()->format('Y-m-d')
        );
    }

}
