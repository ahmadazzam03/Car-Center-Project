<div class="row">
    @foreach ($fuelTypes as $fuelType)
    <div class="col">
        <div class="radio-buttons-container">
            <div class="radio-button">
                <input 
                name="fuel_type_id" 
                value="{{$fuelType->id}}"
                @checked($attributes->get('value')==$fuelType->id) 
                id="{{ $fuelType->id }}" 
                class="radio-button__input" 
                type="radio">
                <label for="{{ $fuelType->id }}" class="radio-button__label">
                <span class="radio-button__custom"></span>
                {{$fuelType->name}}
                </label>
            </div>
            </div>
    </div>
    @endforeach
</div>