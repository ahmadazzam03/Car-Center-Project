<x-app-layout title="Edit Car">
    <main style="margin-top: 80px">
        <div class="container-small">
          <h1 class="car-details-page-title">
            Edit Car: {{$car->getTitle()}}
          </h1>
          
          <form
            action="{{route('car.update',$car)}}"
            method="POST"
            enctype="multipart/form-data"
            class="card add-new-car-form">
            @csrf
            @method('PUT')
            <div class="form-content">
              <div class="form-details">
                <div class="row">
                  <div class="col">
                    {{-- This input for Maker with error validate --}}
                    <div class="form-group 
                    @error('maker_id')
                      has-error
                    @enderror">
                      <label><span style="color: red;display:inline">*</span> Maker</label>
                        <x-select-maker :value="old('maker_id',$car->maker_id)"/>
                      <p class="error-message">{{$errors->first('maker_id')}}</p>
                    </div>
                  </div>

                  <div class="col">
                      {{-- This input for model with error validate --}}
                    <div class="form-group 
                    @error('model_id')
                      has-error
                    @enderror">
                      <label><span style="color: red;display:inline">*</span> Model</label>
                      <x-select-model :value="old('model_id',$car->model_id)"/>
                      <p class="error-message">{{$errors->first('model_id')}}</p>
                    </div>
                  </div>

                  <div class="col">
                    {{-- This input for year with error validate --}}
                    <div class="form-group
                    @error('year')
                      has-error
                    @enderror">
                      <label><span style="color: red;display:inline">*</span> Year</label>
                      <x-select-year :value="old('year',$car->year)"/>
                      <p class="error-message">{{$errors->first('year')}}</p>
                    </div>
                  </div>
                </div>
                    {{-- This input for Car Type with error validate --}}
                <div class="form-group 
                @error('car_type_id')
                  has-error
                @enderror">
                  <label><span style="color: red;display:inline">*</span> Car Type</label>
                  <x-radio-list-car-type :value="old('car_type_id',$car->car_type_id)"/>
                  <p class="error-message">{{$errors->first('car_type_id')}}</p>
                </div>

                <div class="row">
                  <div class="col">
                    {{-- This input for price with error validate --}}
                    <div class="form-group 
                    @error('price')
                      has-error
                    @enderror">
                      <label><span style="color: red;display:inline">*</span> Price</label>
                      <input type="number" 
                      value="{{old('price',$car->price)}}" placeholder="Price" name="price" />
                      <p class="error-message">{{$errors->first('price')}}</p>
                    </div>
                  </div>

                  <div class="col">
                    {{-- This input for vin with error validate --}}
                    <div class="form-group 
                    @error('vin')
                      has-error
                    @enderror">
                      <label><span style="color: red;display:inline">*</span> Vin Code</label>
                      <input placeholder="Vin Code" 
                      value="{{old('vin',$car->vin)}}" name="vin" />
                      <p class="error-message">{{$errors->first('vin')}}</p>
                    </div>
                  </div>

                  <div class="col">
                    {{-- This input for mileage with error validate --}}
                    <div class="form-group
                    @error('mileage')
                      has-error
                    @enderror">
                      <label><span style="color: red;display:inline">*</span> Mileage (ml)</label>
                      <input placeholder="Mileage" name="mileage" value="
                      {{old('mileage',$car->mileage)}}" />
                      <p class="error-message">{{$errors->first('mileage')}}</p>
                    </div>
                  </div>

                </div>
                    {{-- This input for Fuel Type with error validate --}}
                <div class="form-group
                @error('fuel_type_id')
                  has-error
                @enderror">
                  <label><span style="color: red;display:inline">*</span> Fuel Type</label>
                  <x-radio-list-fuel-type :value="old('fuel_type_id',$car->fuel_type_id)"/>
                  <p class="error-message">{{$errors->first('fuel_type_id')}}</p>
                </div>

                <div class="row">
                  <div class="col">
                    {{-- This input for city with error validate --}}
                    <div class="form-group">
                      <label><span style="color: red;display:inline">*</span> City</label>
                      <x-select-state 
                      :value="old('state_id',$car->city->states_id)"/>
                    </div>
                  </div>

                  <div class="col">
                    {{-- This input for Region with error validate --}}
                    <div class="form-group
                    @error('city_id')
                      has-error
                    @enderror">
                      <label><span style="color: red;display:inline">*</span> Region</label>
                      <x-select-city 
                      :value="old('city_id',$car->city_id)"/>
                      <p class="error-message">{{$errors->first('city_id')}}</p>
                    </div>
                  </div>
                  <div class="col">
                    {{-- This input for address with error validate --}}
                    <div class="form-group
                    @error('address')
                      has-error
                    @enderror">
                      <label><span style="color: red;display:inline">*</span> Address</label>
                      <input placeholder="Address" name="address" value="{{old('address',$car->address)}}" />
                      <p class="error-message">{{$errors->first('address')}}</p>
                    </div>
                  </div>
                </div>
            
                {{-- For Car Features  --}}
                  <x-checkbox-car-features :$car/>

                  {{-- This input for description with error validate --}}
                <div class="form-group
                @error('description')
                      has-error
                    @enderror">
                  <label><span style="color: red;display:inline">*</span> Detailed Description</label>
                  <textarea rows="10" name="description" style="resize: none">{{old('description',$car->description)}}
                  </textarea>
                  <p class="error-message">{{$errors->first('description')}}</p>
                </div>

              
              </div>
              <div class="form-images">
                <p>
                  Manage Your images 
                  <a href="{{route('car.images',$car)}}">From here</a>
                </p>
                <div class="car-form-images">
                    @foreach ($car->images as $image)
                      <a href="#" class="car-form-image-preview" >
                        <img src="{{$image->getUrl()}}" loading="lazy" alt="">
                      </a>
                    @endforeach
                </div>
              </div>
            </div>
            <div class="p-medium" style="width: 100%">
              <div class="flex justify-end gap-1">
                <button type="button" class="btn btn-default">Reset</button>
                <button class="btn btn-primary" type="submit">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </main> 

    </x-app-layout>
