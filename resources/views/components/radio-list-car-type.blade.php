<div class="row">
    @foreach ($carTypes as $carType)
    <div class="col">
        
    <div class="radio-buttons-container">
    <div class="radio-button">
        <input 
        name="car_type_id" 
        value="{{$carType->id}}"
        @checked($attributes->get('value')==$carType->id) 
        id="radio_{{ $carType->id }}" 
        class="radio-button__input" 
        type="radio">
        <label for="radio_{{ $carType->id }}" class="radio-button__label">
        <span class="radio-button__custom"></span>
        {{$carType->name}}
        </label>
    </div>
    </div>

    </div>
        @if ($loop->iteration % 3 == 0 && !$loop->last)
    </div>
    <div class="row">   
        @endif    
        @endforeach
</div>