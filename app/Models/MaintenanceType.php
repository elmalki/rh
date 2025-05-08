<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceType extends Model
{
    /** @use HasFactory<\Database\Factories\MaintenanceTypeFactory> */
    use HasFactory;

    protected $fillable = ['label', 'kilometrage', 'maintenance_category_id'];
    protected $with = ['maintenance_category'];

    public function maintenance_category(): BelongsTo
    {
        return $this->belongsTo(MaintenanceCategory::class);
    }
}
