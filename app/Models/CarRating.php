<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarRating extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','car_id','rating'];
    protected $table = 'car_ratings';

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class); 
    }
    public function car():BelongsTo
    {
        return $this->belongsTo(Car::class); 
    }
}
