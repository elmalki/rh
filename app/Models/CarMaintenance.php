<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarMaintenance extends Model
{
    protected $table = "car_maintenance_type";
    protected $fillable = ['car_id','maintenance_id','maintenance_type_id','km','next_km','date','montant','is_last_maintenance_type'];
    public $timestamps = false;

    public function car():BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function maintenance_type():BelongsTo
    {
        return $this->belongsTo(MaintenanceType::class);
    }
    public function maintenance():BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function kilometrage()
    {
        return 253996;
    }
}
