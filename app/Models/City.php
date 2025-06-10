<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name','states_id'];

    public function state(): BelongsTo //return type
    {
            return $this->belongsTo(State::class,'states_id');
    }
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
