<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    /** @use HasFactory<\Database\Factories\DestinationFactory> */
    use HasFactory;
    protected $fillable = ['label','is_internal','trip_km'];
    protected function casts(): array
    {
        return [
            'is_interal' => 'boolean',
        ];
    }
}
