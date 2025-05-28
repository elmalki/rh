<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pointage extends Model
{
    /** @use HasFactory<\Database\Factories\DailyAttendancyFactory> */
    use HasFactory;
    protected $fillable = ['date','wage'];

    public function workers():BelongsToMany
    {
        return $this->belongsToMany(DailyWorker::class,'pointage_worker','pointage_id','daily_worker_id');
    }

}
