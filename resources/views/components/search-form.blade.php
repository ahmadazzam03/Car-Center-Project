<!-- Find a car form -->
  <section class="find-a-car">
    <div class="container">
      <form action="{{route('car.search')}}" method="GET" 
      class="find-a-car-form card flex p-medium">
        <div class="find-a-car-inputs">
          <div>
            {{-- To select all the maker in DataBase --}}
            <x-select-maker/>
            
          </div>
          <div>
            {{-- To select all the model in DataBase --}}
            <x-select-model/>
          </div>
          <div>
            {{-- To select all the states in DataBase --}}
            <x-select-state/>
          </div>
          <div>
            {{-- To select all the city in DataBase --}}
            <x-select-city/>
            
          </div>
          <div>
            {{-- To select all the carTypes in DataBase --}}
            <x-select-car-type/>
          </div>
          <div>
            <input type="number" placeholder="Year From" name="year_from" />
          </div>
          <div>
            <input type="number" placeholder="Year To" name="year_to" />
          </div>
          <div>
            <input
              type="number"
              placeholder="Price From"
              name="price_from"
            />
          </div>
          <div>
            <input type="number" placeholder="Price To" name="price_to" />
          </div>
          <div>
            {{-- To select all the fuelType in DataBase --}}
            <x-select-fuel-type/>
          </div>
        </div>
        <div>
          <button type="button" class="btn btn-find-a-car-reset">
            Reset
          </button>
          <button class="btn btn-primary btn-find-a-car-submit">
            Search
          </button>
        </div>
      </form>
    </div>
  </section>
  <!--/ Find a car form -->