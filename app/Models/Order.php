<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
    'user_id',
    'car_id',
    'status',
    'price',
    'address', // تأكد من وجود هذا الحقل
    'city',
    'state',
    'zip_code',
    'card_name',
    'card_number',
    'cvv',
    ];
    protected $table = 'orders';

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class); 
    }
    public function car():BelongsTo
    {
        return $this->belongsTo(Car::class); 
    }
    public function getCreateDate():string
    {
        return (new Carbon($this->created_at))
        ->format('Y-m-d');
    }   
    

}
