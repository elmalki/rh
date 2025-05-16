<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leave extends Model
{
    /** @use HasFactory<\Database\Factories\LeaveFactory> */
    use HasFactory;
    protected $fillable = ['file','status','start_date','end_date','personnel_id','leave_type_id'];
    protected $with = ['personnel','leaveType'];
    protected $appends = ['days'];
    public function personnel():BelongsTo{
        return $this->belongsTo(Personnel::class);
    }
    public function leaveType():BelongsTo{
        return $this->belongsTo(Leavetype::class,'leave_type_id');
    }

    public function days():Attribute
    {
        return Attribute::make(get: fn()=>Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date)));
    }
    public function startDate():Attribute{
        return Attribute::make(set:fn($value)=>Carbon::parse($value)->addHour()->format('Y-m-d'));
    }
    public function endDate():Attribute{
        return Attribute::make(set:fn($value)=>Carbon::parse($value)->addHour()->format('Y-m-d'));
    }
}
