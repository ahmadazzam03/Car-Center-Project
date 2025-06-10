<x-app-layout title="Complete Payment">
    <div class="checkout-container" style="margin-top: 80px">
        <form action="{{route('orders.store')}}" method="post">
            @csrf
            <input type="hidden" name="purchase_request_id" value="{{ $purchaseRequest->id }}">
            
            <div class="checkout-show-car">
                <h1 class="car-details-page-title">
                    {{$purchaseRequest->car->maker->name}} - 
                    {{$purchaseRequest->car->model->name}} - 
                    {{$purchaseRequest->car->year}}
                </h1> 
                <img src="{{ $purchaseRequest->car->primaryImage?->getUrl() ?? 
                '/img/no-image.png' }}"
                style="width: 150px;margin:10px auto" />
            </div>

            <div class="row">
                <div class="col">
                    <h3 class="title">
                        Billing Address
                    </h3>
                    
                    {{-- <div class="inputBox
                    @error('name')
                        has-error
                    @enderror">
                        <label for="name">
                            Full Name:
                        </label>
                        <input type="text" name="name" id="name" value="{{auth()->id()}}"  placeholder="Enter your full name" >
                        <p class="validate_error">{{$errors->first('name')}}</p>

                    </div> --}}

                    {{-- <div class="inputBox
                    @error('email')
                        has-error
                    @enderror">
                        <label for="email">
                            Email:
                        </label>
                        <input type="email"  name="email" value="{{$user->email}}"  id="email" placeholder="Enter email address" >
                        <p class="validate_error">{{$errors->first('email')}}</p>
                    </div> --}}

                    <div class="inputBox
                    @error('address')
                        has-error
                    @enderror">
                        <label for="address">
                            Address:
                        </label>
                        <input type="text" name="address"  id="address" value="{{old('address')}}" placeholder="Enter your address" >
                        <p class="validate_error">{{$errors->first('address')}}</p>

                    </div>

                    <div class="inputBox
                    @error('city')
                        has-error
                    @enderror">
                        <label for="city">
                            City:
                        </label>
                        <input type="text" id="city" name="city" value="{{old('city')}}" placeholder="Enter your city" >
                        <p class="validate_error">{{$errors->first('city')}}</p>

                    </div>

                    <div class="flex">
                        <div class="inputBox
                        @error('state')
                        has-error
                        @enderror">
                            <label for="state">
                                Region:
                            </label>
                            <input type="text" id="state" name="state" value="{{old('state')}}" placeholder="Enter state" >
                            <p class="validate_error">{{$errors->first('state')}}</p>

                        </div>

                        <div class="inputBox
                        @error('zip_code')
                        has-error
                        @enderror">
                            <label for="zip">
                                Zip Code:
                            </label>
                            <input type="text" id="zip" name="zip_code" value="{{old('zip_code')}}" 
                            placeholder="Enter 6 digit" maxlength="6">
                            <p class="validate_error">{{$errors->first('zip_code')}}</p>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <h3 class="title">Payment</h3>
                    <div class="inputBox">
                        <label for="name">
                            Card Accepted:
                        </label>
                        <img src="/img/Online-Payment-Project.webp" alt="credit/debit card image">
                    </div>

                    <div class="inputBox
                    @error('card_name')
                        has-error
                    @enderror">
                        <label for="cardName">
                            Name On Card:
                        </label>
                        <input  type="text" name="card_name" value="{{old('card_name')}}" id="cardName" placeholder="Enter card name" >
                        <p class="validate_error">{{$errors->first('card_name')}}</p>

                    </div>

                    <div class="inputBox
                    @error('cridt_card_number')
                        has-error
                    @enderror">
                        <label for="cridt_card_number">
                            Credit Card Number:
                        </label>
                        <input type="text" name="cridt_card_number" 
                            value="{{old('cridt_card_number')}}" 
                            placeholder="0000 0000 0000 0000" 
                            id="cridt_card_number" 
                            maxlength="19" >
                            <p class="validate_error">{{$errors->first('cridt_card_number')}}</p>
                        </div>


                    <div class="flex">
                        <div class="inputBox
                        @error('cvv')
                        has-error
                        @enderror">
                            <label for="cvv">CVV</label>
                            <input type="text" name="cvv" id="cvv" 
                            value="{{old('cvv')}}" placeholder="1234" maxlength="4" >
                            <p class="validate_error">{{$errors->first('cvv')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <input type="submit" value="Confirm Payment" 
                class="submit_btn">
        </form>
    </div>
</x-app-layout>
