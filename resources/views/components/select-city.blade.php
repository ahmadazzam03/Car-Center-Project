<select id="citySelect" name="city_id">
    <option value="" style="display: block">Region</option>
    @foreach ($cities as $city)
    <option value="{{$city->id}}" 
        data-parent="{{$city->states_id}}"
        @selected($attributes->get('value')== $city->id)>
        {{$city->name}}
    </option>
    @endforeach
</select>