<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarType extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name'];
    // this is mean for every car has one car type but car type have many cars 
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
