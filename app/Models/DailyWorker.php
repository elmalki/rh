<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DailyWorker extends Model
{
    /** @use HasFactory<\Database\Factories\DailyWorkerFactory> */
    use HasFactory;
    protected $fillable = ['nom','prenom','cnie','sexe'];
    protected $appends = ['nom_complet'];
    public function prenom(): Attribute
    {
        return Attribute::make(set: fn($value) => Str::title($value));
    }

    public function nom(): Attribute
    {
        return Attribute::make(set: fn($value) => Str::upper($value));
    }
    public function cnie(): Attribute
    {
        return Attribute::make(set: fn($value) => Str::upper($value));
    }
    public function nomComplet(): Attribute
    {
        return Attribute::make(get: fn() => $this->prenom.' '.$this->nom);
    }
}
