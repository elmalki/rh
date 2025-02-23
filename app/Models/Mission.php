<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mission extends Model
{
    /** @use HasFactory<\Database\Factories\MissionFactory> */
    use HasFactory;

    protected $fillable = ['depart_date', 'return_date', 'mission', 'destination_id'];
    protected $with = ['equipes'];

    public function equipes():HasMany
    {
        return $this->hasMany(Equipe::class, 'mission_id');
    }
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

}
