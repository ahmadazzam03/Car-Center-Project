@props(['car','isInWishList'=>false])

<div class="car-item card">
  {{-- This route to redirect it tp page that show or siplay the car details  --}}
    <a href="{{route('car.show',$car->id)}}">
      @isset($car->primaryImage)
      <img src="{{$car->primaryImage->getUrl()}}" loading="lazy" class="car-item-img rounded-t"/>
      @else
      <img src="/img/no-image.png" loading="lazy" class="car-item-img rounded-t">
      @endisset
    </a>

    <div class="p-medium">
      <div class="flex items-center justify-between">
        <small class="m-0 text-muted">
        @isset($car->city->state->name)
          {{ $car->city->state->name }} - 
        @endisset
        @isset($car->city->name)
            {{ $car->city->name }}
        @endisset
        </small>
        <button class="btn-heart text-primary" 
        data-url="{{route('wishList.storeDestroy',$car)}}">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            style="width: 18px"
            @class(['hidden' =>$isInWishList ])>
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
          </svg>
          <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      style="width: 18px"
                      @class(['hidden' =>!$isInWishList ])>
                      <path
                        d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z"/>
          </svg>
        </button>
      </div>
      <h2 class="car-item-title">{{$car->getTitle()}}</h2>
      <p class="car-item-price">{{$car->price}} JOD</p>
      {{-- rating  car --}}
      @auth
        <div class="rating-css " style="margin-bottom: 8px">
        <div class="star-icon">
          @if($car->ratings_avg_rating)
          @for ($i = 1 ; $i <=  floor($car->ratings_avg_rating);$i++)   
          <span class="fa fa-star" style="color: yellow"></span>         
          @endfor

          @for ($i=ceil($car->ratings_avg_rating) ; $i <5; $i++)   
          <span class="fa fa-star gray"></span>          
          @endfor

            <div class="rate">
              <p class="avg"> ({{number_format($car->ratings_avg_rating??0.0, 1)}} / 5)</p>
              <p class="count">({{$car->ratings_count}})</p>
            </div>

            @else

            @for ($i = 1; $i <= 5; $i++)   
            <span class="fa fa-star gray"></span>                
            @endfor

            <div class="rate">
              <p class="avg"> ({{number_format($car->ratings_avg_rating??0.0, 1)}} / 5)</p>
              <p class="count">({{$car->ratings_count}})</p>
            </div>
            @endif
          </div>
        </div>  
      @endauth

      <hr/>
      <p class="my-large" style="justify-content:space-between ;display: flex">
        <span class="car-item-badge">{{$car->carType->name}}</span>
        <span class="car-item-badge">{{$car->fuelType->name}}</span>
      </p>
    </div>
  </div>