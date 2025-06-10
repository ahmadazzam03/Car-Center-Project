<x-app-layout title="My Favourite Cars">
    <main style="margin-top: 60px">
        <!-- New Cars -->
        <section>
            <div class="container">
              <div class="flex justify-between items-center">
                  <h2>My Favourite Cars</h2>
                  {{-- To display how many cars we find in wishList page --}}
                  @if ($cars->total()>0)
                      <div class="pagination-summary">
                        <p>
                          Showing {{$cars->firstItem()}} to 
                          {{$cars->lastItem()}} of {{$cars->total()}} results
                        </p>
                      </div>
                  @endif
              </div>

              <div class="car-items-listing">
                    @foreach ($cars as $car)
                        <x-car-item :$car :isInWishList="true"/>
                    @endforeach
              </div>
              @if($cars->count()==0)
              <div class="text-center p-large">
                You don't have any favourite cars.
              </div>
              @endif
            </div>
              {{$cars->onEachSide(1)->links()}}
        </section>
        <!--/ New Cars -->
      </main>
</x-app-layout>