<x-admin-app title="Request Management" >
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
          <h3>Manage Car Owner Requests </h3>
    
          <div class="table-responsive">
              <table>
                  <thead>
                      <tr>
                        <th>Car Image</th>
                        <th>Owner ID</th>
                        <th>Owner Name</th>
                        <th>Owner Email</th>
                        <th>Phone</th>
                        <th>Car Details</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Approve</th>
                        <th>Decline</th>
                      </tr>
                  </thead>
                    <tbody id="userTable">
                      @forelse($cars as $car)
                      <tr>
                        <td>
                        <img
                        src="{{$car->primaryImage?->getUrl() ?: '/img/no-image.png'}}"  
                        style="display:flex;padding:8px;width:150px; border-radius: 12px;"/>
                        </td>
                        <td>{{$car->owner->id}}</td>
                        <td>{{$car->owner->name}}</td>
                        <td>{{$car->owner->email}}</td>
                        <td>{{$car->owner->phone}}</td>
                        <td>{{$car->year}} - {{$car->maker->name}} - {{$car->model->name}}</td>
                        <td>{{$car->getCreateDate()}}</td>
                        
                            @if ($car->status ==='Approved')    
                            <td style="color:green;font-weight:500;">
                                {{$car->status}}
                            </td>
                            @elseif($car->status ==='Declined')
                            <td style="color:red;font-weight:500;">
                                {{$car->status}}
                            </td>
                            @elseif($car->status ==='Sold')
                            <td style="color:orange;font-weight:500;">
                                {{$car->status}}
                            </td>
                            @else
                            <td style="color:black;font-weight:500;">
                                {{$car->status}}
                            </td>
                            @endif
                        
                        
                            @if ($car->status ==='Approved' ||$car->status ==='Declined' ||$car->status ==='sold' )
                            <td></td>
                            <td></td>
                            @elseif($car->status ==='pending')
                            <td>
                                <form 
                                id="approve-request-form-{{ $car->id }}"
                                action="{{ route('admin.approveRequest', $car) }}"
                                method="POST"
                                >
                                @csrf
                                @method('PUT')
                                <button 
                                type="button" 
                                onclick="confirmApprove({{ $car->id }})" 
                                class="btn inline-flex items-center" 
                                style="margin-right:10px;background-color:green;color:white">
                                Approve
                                </button>
                                </form>
                            </td>
                            <td>
                                <form 
                                        id="decline-request-form-{{ $car->id }}"
                                        action="{{route('admin.declineRequest',$car)}}"
                                        method="POST"
                                        >
                                        @csrf
                                        @method('PUT')
                                        <button
                                        type="button"
                                        onclick="confirmDecline({{ $car->id }})" 
                                        class="btn inline-flex items-center" style="background-color: rgb(212, 10, 10);color:white">
                                        Decline
                                        </button>
                                </form>
                                <script>
                                    function confirmApprove(carId) {
                                        Swal.fire({
                                            title: "Are you sure?",
                                            text: "You want to approve this Request!",
                                            icon: "success",
                                            showCancelButton: true,
                                            confirmButtonColor: "#28a745",
                                            cancelButtonColor: "#d33",
                                            confirmButtonText: "Yes, approve it!"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                document.getElementById('approve-request-form-' + carId).submit();
                                            }
                                        });
                                    }
                                
                                    function confirmDecline(carId) {
                                        Swal.fire({
                                            title: "Are you sure?",
                                            text: "You want to decline this request!",
                                            icon: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#d33",
                                            cancelButtonColor: "#3085d6",
                                            confirmButtonText: "Yes, decline it!"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                document.getElementById('decline-request-form-' + carId).submit();
                                            }
                                        });
                                    }
                                </script>
                            </td>
                            @endif
                            
                            
                        </tr>
                      @empty
                      <tr>
                        <td colspan="5" class="text-center p-large">
                          You don't have any Requests yet. 
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