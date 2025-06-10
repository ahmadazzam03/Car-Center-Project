<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Carfeatures;
use App\Models\CarImage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Car extends Model
{
          use HasFactory , SoftDeletes;
          protected $fillable = 
          [
               'maker_id',
               'model_id',
               'car_type_id',
               'fuel_type_id',
               'owner_id',
               'city_id',
               'year',
               'price',
               'vin',
               'mileage',
               'address',
               'phone',
               'description',
               'status',
               'published_at',
          ];

          public function fuelType():BelongsTo
          {
               return $this->belongsTo(FuelType::class);
          }
          public function maker():BelongsTo
          {
               return $this->belongsTo(Maker::class);
          }
          public function model():BelongsTo
          {
               return $this->belongsTo(CarModel::class);
          }
          public function city():BelongsTo
          {
               return $this->belongsTo(City::class);
          }
          public function owner():BelongsTo
          {
               return $this->belongsTo(User::class,'owner_id');
          }

          /**
           * Summary of CarType
          * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
          *   This method that act a relation method between 
          *    car and car Type  tabled so the relation is every car 
          *    has one
          *    car Type but every CarType have many of Cars 

          */
          public function CarType():BelongsTo 
          {
               return $this->belongsTo(CarType::class);
          }
          /*
          يتم تعريف علاقة 
          One-to-One
          بين نموذج 
          Car 
          ونموذج 
          Carfeatures 
          باستخدام طريقة 
          hasOne.
          هذا يعني أن لكل سيارة 
          (Car) 
          ميزات 
          (Carfeatures) 
          واحدة مرتبطة به
          */
          public function features(): HasOne //return type
          {
               return $this->hasOne(Carfeatures::class,'car_id');
          }

          public function primaryImage(): HasOne //return type
          {
               /*
               الموجه 
               oldestOfMany 
               هو ميزة إضافية تستخدم لاسترجاع السجل الأقدم من بين سجلات العلاقة،
               وهو مفيد إذا كان لديك عدة صور مرتبطة بسيارة وتريد جلب الصورة الأقدم فقط.
               */
               return $this->hasOne(CarImage::class,'car_id')
               ->oldestOfMany('position');
               //position => the colum that laravel look at when arrange image 
          }

          public function images():HasMany 
               {
                    return $this->hasMany(CarImage::class);
               }
          public function orders():HasMany 
          {
               return $this->hasMany(Order::class);
          }

          public function ratings():HasMany
          {
               return $this->hasMany(CarRating::class); 
          }
          public function comments():HasMany
          {
               return $this->hasMany(Comment::class); 
          }

     /**
      * Summary of favouredUsers
      * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
      *   This relation indicate the relation between car and users tables 
      *   so for every users hava a many of (favourite cars) and every
      *   car have many users thier favourite it's 
      *   but we use a pivot table called (favourite _cars) to store  
      *   the favourite cars in it . 
      *   and we use two forign key called (car_id in favouite_cars table , user_id in users table )
      */
          public function favouredUsers():BelongsToMany
          {
               return $this->belongsToMany(User::class,
               'favourite_cars','car_id','user_id');
          }     
          public function getCreateDate():string
          {
               return (new Carbon($this->created_at))->format('Y-m-d');
          }     

          public function getTitle()
          {
               return $this->year .' - '.$this->maker->name.' - '.$this->model->name;
          }

          public function isInWishList(User $user=null)
          {
               return $this->favouredUsers->contains($user);
          }
          public function averageRating()
          {
               return $this->ratings()->avg('rating') ?? 0; 
          }
          
          public function totalRatings()
          {
               return $this->ratings()->count();
          }

          public function purchaseRequests()
          {
          return $this->hasMany(PurchaseRequest::class);
          }



}
