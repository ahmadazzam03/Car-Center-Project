<x-app-layout title="My Cars" bodyClass="page-my-cars">
    <main style="margin-top: 70px">
        <div>
          <div class="container">
            <h1 class="car-details-page-title">My Cars</h1>
            <div class="card p-medium">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Car Image</th>
                      <th scope="col">Car Detail</th>
                      <th scope="col">Car Rating</th>
                      <th scope="col">Price</th>
                      <th scope="col">Created At</th>
                      <th scope="col">Status</th>
                      <th scope="col">Edit Car</th>
                      <th scope="col">Edit Car Image</th>
                      <th scope="col">Delete Car</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($cars as $car)
                    <tr>
                      <td>
                        <img
                          src="{{$car->primaryImage?->getUrl() ?: '/img/no-image.png'}}" 
                          class="my-cars-img-thumbnail" 
                          style="display:flex;padding:8px;width:150px"
                          loading="lazy"
                          />
                      </td>
                      <td>{{$car->year}} - {{$car->maker->name}} - {{$car->model->name}}</td>
                      <td> 
                        @if($car->ratings_avg_rating)
                        @for ($i = 1; $i <= floor($car->ratings_avg_rating); $i++)   
                        <span class="fa fa-star" style="color: yellow"></span>          
                        @endfor

                        @for ($i = ceil($car->ratings_avg_rating); $i < 5; $i++)     
                        <span class="fa fa-star gray"></span>          
                        @endfor

                        <span class="avg">
                          ({{number_format($car->ratings_avg_rating??0.0, 1)}} / 5)
                        </span>
                        <span class="count">({{$car->ratings_count}})</span>
                        @else

                        @for ($i = 0; $i < 5; $i++)   
                        <span class="fa fa-star gray"></span>          
                        @endfor

                          <span class="avg">({{number_format($car->ratings_avg_rating??0.0, 1)}} / 5)</span></span>
                          <span class="count">({{$car->ratings_count}})</span>
                        @endif
                      </td>

                      <td>{{ $car->price}} JOD</td>
                      <td>{{ $car->getCreateDate()}}</td>
                      <td>{{ $car->status}}</td>
                      <td>
                        <a
                          href="{{route('car.edit',$car)}}" class="btn btn-edit inline-flex items-center">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            style="width: 12px; margin-right: 5px">
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                          </svg>
                          Edit
                        </a>
                      </td>
                      <td>
                        <a
                          href="{{route('car.images',$car)}}" class="btn btn-edit inline-flex items-center">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            style="width: 12px; margin-right: 5px">
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                          </svg>
                          Images
                        </a>
                      </td>
                      <td>
                          <form 
                          id="delete-car-form-{{ $car->id }}"
                          action="{{route('car.destroy',$car)}}"
                          method="POST"
                          class="inline-flex">
                          @csrf
                          @method('DELETE')
                          <button type="button" 
                          onclick="confirmDelete({{ $car->id }}) " 
                          class="btn btn-delete inline-flex items-center">
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
                      <td colspan="9" class="text-center p-large">
                        You don't have any cars yet. 
                        <a href="{{route('car.create')}}" class="btn btn-primary">Add new car</a>
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

            </div>
          </div>
          {{ $cars->onEachSide(1)->links()}}
        </div>
      </main>
</x-app-layout>
