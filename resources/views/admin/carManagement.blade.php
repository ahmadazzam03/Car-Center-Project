<x-admin-app title="Car Management">
    <!-- MAIN CONTAINER  -->
    <div class="main-container">
        <!-- TITLE  -->
        <div class="title">
          <p>
            <a href="{{route('admin.dashboard')}}"><span>Dashboard</span></a>
            <i class="bx bx-right-arrow-alt"></i>
            Car Center
          </p>
          <select class="status-filter my-large" style="float:right; margin-left: 15px;">
            <option value="">All Statuses</option>
            <option value="pending" {{ $statusFilter === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="Approved" {{ $statusFilter === 'Approved' ? 'selected' : '' }}>Approved</option>
            <option value="Declined" {{ $statusFilter === 'Declined' ? 'selected' : '' }}>Declined</option>
            <option value="Sold" {{ $statusFilter === 'Sold' ? 'selected' : '' }}>Sold</option>
          </select>

          <select class="sort-dropdown my-large" style="float:right">
            <option value="">Order By</option>
            <option value="created_at">Created At Asc</option>
            <option value="-created_at">Created At Desc</option>
            <option value="year">Year Asc</option>
            <option value="-year">Year Desc</option>
            <option value="mileage">Mileage Asc</option>
            <option value="-mileage">Mileage Desc</option>
            <option value="published_at">Newest At the top</option>
            <option value="-published_at">Oldest At the top</option>
            <option value="price">Price Asc</option>
            <option value="-price">price Desc</option>
          </select>
          <h3>Car Managment</h3>
    
          <div class="table-responsive">
              <table>
                  <thead>
                      <tr>
                        <th>Car ID </th>
                        <th>Owner Name</th>
                        <th>Car Image </th>
                        <th>Car Deatil </th>
                        <th>price</th>
                        <th>Vin</th>
                        <th>Mileage</th>
                        <th>Published_At</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Delete</th>
                      </tr>
                  </thead>
    
                    <tbody id="userTable">
                        @forelse($cars as $car)
                        <tr>
                            <td>{{$car->id}}</td>
                            <td>{{$car->owner->name}}</td>
                          <td>
                            <img
                              src="{{$car->primaryImage?->getUrl() ?: '/img/no-image.png'}}" 
                              style="display:flex;padding:8px;border-radius: 12px;" 
                              width="100px" height="100px"/>
                          </td>
                          <td>{{$car->year}} - {{$car->maker->name}} - {{$car->model->name}}</td>
                          {{-- <td > 
                            @if($car->averageRating())
                            @for ($i = 1 ; $i <= $car->averageRating();$i++)   
                            <span class="fa fa-star" style="color: yellow"></span>          
                            @endfor
                            @for ($i=$car->averageRating();$i <5;$i++)   
                            <span class="fa fa-star gray"></span>          
                            @endfor
                            <span class="avg"> ({{number_format($car->averageRating(), 1)}} / 5)</span>
                            <span class="count">({{$car->totalRatings()}})</span>
                            @else
                            @for ($i=$car->averageRating();$i <5;$i++)   
                            <span class="fa fa-star gray"></span>          
                            @endfor
                              <span class="avg"> ({{number_format($car->averageRating(), 1)}} / 5)</span>
                              <span class="count">({{$car->totalRatings()}})</span>
                            @endif
                          </td> --}}
                          <td>{{ $car->price}} JOD</td>
                          <td>{{ $car->vin}}</td>
                          <td>{{ $car->mileage}}</td>
                          <td>{{ $car->published_at}}</td>
                          <td>{{ $car->getCreateDate()}}</td>
                          <td>{{ $car->status}}</td>
                        <td>
                          <form 
                          id="delete-car-form-{{ $car->id }}"
                          action="{{route('admin.deleteCar',$car)}}"
                          method="POST"
                          class="inline-flex">
                          @csrf
                          @method('DELETE')
                          <button type="button"  
                          onclick="confirmDelete({{ $car->id }}) " 
                          class="reject-btn">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke-width="1.5"
                              stroke="currentColor"
                              style="width: 12px; margin-right: 5px"
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                              />
                            </svg>
                            Delete
                          </button>
                        </form>
                        <script>
                          function confirmDelete(carId) {
                              Swal.fire({
                                  title: "Are you sure?",
                                  text: "You won't be able to revert this car!",
                                  icon: "warning",
                                  showCancelButton: true,
                                  confirmButtonColor: "#3085d6",
                                  cancelButtonColor: "#d33",
                                  confirmButtonText: "Yes, delete it!"
                              }).then((result) => {
                                  if (result.isConfirmed) {
                                      document.getElementById('delete-car-form-' + carId).submit();
                                  }
                              });
                          }
                      </script>
                        </td>
                        </tr>
                      @empty
                      <tr>
                        <td colspan="5" class="text-center p-large">
                          You don't have any Cars yet. 
                        </td>
                      </tr>
                      @endforelse
                    </tbody>
              </table>
            </div>
          </div>
          {{$cars->appends(['sort' => request('sort'), 'status' => request('status')])->onEachSide(1)->links()}}

      </div>
      <div class="backdrop-filter"></div>
    
    </x-admin-app>