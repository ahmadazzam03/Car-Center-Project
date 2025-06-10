<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class CarModel extends EloquentModel 
{
    use HasFactory;
    protected $table = 'models';
    public $timestamps = false;

    protected $fillable = ['name','maker_id'];

    public function maker(): BelongsTo
    {
        return $this->belongsTo(Maker::class,'maker_id');
    }
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
