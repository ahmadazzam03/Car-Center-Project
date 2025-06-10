<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
//To implement email verification after registration
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'profile_image',
        'phone',
        'role_id',
        'google_id',
        'facebook_id',
        'password',
        'email_verified_at'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function favouriteCars():BelongsToMany
    {
        return $this->belongsToMany(Car::class,'favourite_cars','user_id','car_id')
        ->withPivot('id')
        ->orderBy('favourite_cars.id','desc');
    }
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class,'owner_id');
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function role():BelongsTo
    {
        return $this->belongsTo(Role::class); 
    }

    public function comments():HasMany
    {
        return $this->hasMany(Comment::class); 
    }
    public function ratings()
    {
        return $this->hasMany(CarRating::class);
    }
    public function isOauthUser():bool
    {
        return !$this->password; 
    }
    public function getCreateDate():string
    {
        return (new Carbon($this->created_at))
        ->format('Y-m-d');
    }   
    public function purchaseRequests()
    {
        return $this->hasMany(PurchaseRequest::class, 'buyer_id');
    }

    public function receivedPurchaseRequests()
    {
        return $this->hasManyThrough(
            PurchaseRequest::class,
            Car::class,
            'owner_id',       
            'car_id',        
            'id',            
            'id'          
        );
    }


}
