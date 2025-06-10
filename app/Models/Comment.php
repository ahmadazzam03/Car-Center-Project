<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ['user_id','car_id','comment']; 

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class); 
    }
    public function car():BelongsTo
    {
        return $this->belongsTo(Car::class); 
    }
}
