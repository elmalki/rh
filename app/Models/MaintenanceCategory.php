<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceCategory extends Model
{
    /** @use HasFactory<\Database\Factories\MaintenanceCategroyFactory> */
    use HasFactory;
    protected $fillable = ['label'];
}
