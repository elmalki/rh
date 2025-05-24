<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    /** @use HasFactory<\Database\Factories\DailyAttendancyFactory> */
    use HasFactory;
    protected $fillable = ['date','daily_worker_id','wage'];
    protected $with = ['worker'];
    public function worker()
    {
        return $this->belongsTo(DailyWorker::class,'daily_worker_id');
    }

    public function getDay()
    {
        return substr($this->date,0,2);
    }
}
