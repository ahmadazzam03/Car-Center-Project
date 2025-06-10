<x-app-layout title="My Orders" >
    <main style="margin-top: 80px">
        
          <div class="container">
            <h1 class="car-details-page-title">My Order</h1>
            <div class="card p-medium">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Car Image </th>
                      <th>Car Deatil </th>
                      <th>price</th>
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
                  <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <img
                                src="{{$order->car->primaryImage?->getUrl() ?: 
                                '/img/no-image.png'}}" 
                                class="my-cars-img-thumbnail" 
                                style="display:flex;padding:8px;width:110px"
                                loading="lazy"
                                alt="Car Image"/>
                        </td>
                        <td>{{$order->car->year}} - {{$order->car->maker->name}} - {{$order->car->model->name}}</td>
                        <td>{{$order->car->price}} JOD</td>
                        <td>{{$order->address}} </td>
                        <td>{{$order->city}} </td>
                        <td>{{$order->state}} </td>
                        <td>{{$order->zip_code}} </td>
                        <td>{{$order->card_name}} </td>
                        <td>**** **** **** {{ substr($order->card_number, -4) }}</td>
                        <td>•••</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>✅{{$order->status}}</td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="12" class="text-center p-large">
                        <strong>No orders found.</strong> 
                        <br> 
                        <a href="{{ route('car.search') }}" class="btn btn-primary mt-2">Browse Cars</a>
                    </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $orders->onEachSide(1)->links()}}
            </div>
          </div>
      
      </main>
</x-app-layout>
