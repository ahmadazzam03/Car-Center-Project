@props(['car'=>null])
@php
    $features = 
    [
        'air_conditioning'=>'Air Conditioning',
        'power_windows'=>'Power Windows',
        'power_door_locks'=>'Power Door Locks',
        'abs'=>'ABS',
        'cruise_control'=>'Cruise Control',
        'bluetooth_connectivity'=>'Bluetooth Connectivity',
        'remote_start'=>'Remote Start',
        'gps_navigation'=>'Gps Navigation System',
        'heater_seats'=>'Heater Seats',
        'climate_control'=>'Climate Control',
        'rear_parking_sensors'=>'Rear Parking Sensors',
        'leather_seats'=>'Leather Seats',
    ]; 
@endphp
<div class="form-group">
        <div class="row">
        <div class="col">
            @foreach ($features as $key => $feature)
            <label class="checkbox-container" >
                <input  type="checkbox" 
                name="features[{{$key}}]"
                value="1"
                @checked(old('features.'.$key,$car?->features->$key))>
                {{$feature}} 
                <div class="checkmark"></div>
            </label>
            @if ($loop->iteration % 6 == 0 && !$loop->last)
        </div> 
        <div class="col">
            @endif
            @endforeach
        </div>
    </div>
</div>