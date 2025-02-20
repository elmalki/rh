<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    /** @use HasFactory<\Database\Factories\BudgetFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = ['label','value','remaining'];

    public function createdAt():Attribute
    {
        return Attribute::make(get:fn($value)=>Carbon::parse($value)->format('Y-m-d'));
    }
}
