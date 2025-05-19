<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Personnel extends Model
{
    /** @use HasFactory<\Database\Factories\PersonnelFactory> */
    use HasFactory;

    protected $fillable = ['ppr', 'cnie','grade','situation','firstname', 'lastname','sexe', 'driving_license', 'birthdate', 'recruitment_date', 'is_driver', 'children', 'department_id'];
    protected $with = ['department'];
    protected $appends = ['fullname'];

    public function firstname(): Attribute
    {
        return Attribute::make(set: fn($value) => Str::title($value));
    }

    public function lastname(): Attribute
    {
        return Attribute::make(set: fn($value) => Str::upper($value));
    }
    public function cnie(): Attribute
    {
        return Attribute::make(set: fn($value) => Str::upper($value));
    }


    public function fullname():Attribute
    {
        return Attribute::make(get: fn() => $this->firstname.' '.$this->lastname);
    }
    public function birthdate(): Attribute{
        return Attribute::make(set: fn($value) =>Carbon::parse($value)->format('Y-m-d'));
    }
    public function recruitmentDate(): Attribute{
        return Attribute::make(set: fn($value) =>Carbon::parse($value)->format('Y-m-d'));
    }

    protected function casts(): array
    {
        return [
            'is_married' => 'boolean',
            'is_driver' => 'boolean'
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
