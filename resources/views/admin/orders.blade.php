<x-admin-app title="Orders Page " >

    <!-- MAIN CONTAINER  -->
    <div class="main-container" >
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
          </select>

          <select class="sort-dropdown my-large" style="float:right">
            <option value="">Order By</option>
            <option value="created_at">Created At Asc</option>
            <option value="-created_at">Created At Desc</option>
            <option value="price">Price Asc</option>
            <option value="-price">price Desc</option>
            <option value="user_name">Buyer Name Asc</option>
            <option value="-user_name">Buyer Name Desc</option>
          </select>
          <h3>All Orders </h3>
          <div class="table-responsive">
              <table>
                  <thead>
                      <tr>
                      <th>Order ID </th>
                      <th>Car Image </th>
                      <th>Car Deatil </th>
                      <th>price</th>
                      <th>Buyer Name </th>
                      <th>address</th>
                      <th>city</th>
                      <th>state</th>
                      <th>Zip Code</th>
                      <th>Card Name</th>
                      <th>Card Number</th>
                      <th>CVV</th>
                      <th>Created At</th>
                      <th>Status</th>
                      </tr>
                  </thead>
                    <tbody id="userTable">
                      @forelse($orders as $order)
                      <tr>
                        <td>{{$order->id}}</td>
                        <td>
                            <img
                                src="{{$order->car->primaryImage?->getUrl() ?: '/img/no-image.png'}}" 
                                style="display: flex;padding:8px;width:120px; border-radius: 12px;"/>
                        </td>
                        <td>{{$order->car->year}} - {{$order->car->maker->name}} - {{$order->car->model->name}}</td>
                        <td>{{$order->car->price}} JOD</td>
                        <td>{{$order->user->name}} </td>
                        <td>{{$order->address}} </td>
                        <td>{{$order->city}} </td>
                        <td>{{$order->state}} </td>
                        <td>{{$order->zip_code}} </td>
                        <td>{{$order->card_name}} </td>
                        <td>{{$order->card_number}} </td>
                        <td>{{$order->cvv}} </td>
                        <td>{{$order->getCreateDate()}}</td>
                        <td>{{$order->status}}</td>
                        </tr>
                      @empty
                      <tr>
                        <td colspan="5" class="text-center p-large">
                          You don't have any orders yet. 
                        </td>
                      </tr>
                      @endforelse
                    </tbody>
              </table>
          </div>

        </div>
        {{$orders->appends(['sort' => request('sort'), 'status' => request('status')])->onEachSide(1)->links()}}

      </div>
      <div class="backdrop-filter"></div>
    </x-admin-app>