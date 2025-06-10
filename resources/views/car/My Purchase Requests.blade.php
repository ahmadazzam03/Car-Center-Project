<x-app-layout title="My Purchase Requests">
    <main style="margin-top: 80px">
        <div class="container">
            <h1 class="car-details-page-title">My Purchase Requests</h1>
            <div class="card p-medium">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Car Image </th>
                                <th>Car Deatil </th>
                                <th>price</th>
                                <th>Status</th>
                                <th>Requested At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $request)
                                <tr>
                                    <td>
                                        <img src="{{ $request->car->primaryImage?->getUrl() ?? '/img/no-image.png' }}"
                                            class="my-cars-img-thumbnail"
                                            style="width: 150px; padding: 8px"
                                            loading="lazy" />
                                    </td>
                                    <td>{{ $request->car->year }} - {{ $request->car->maker->name }} - {{ $request->car->model->name }}</td>
                                    <td>{{ $request->car->price }} JOD</td>
                                    <td>
                                        @if($request->status === 'approved')
                                            <span style="color: rgb(80, 193, 80);font-weight:bold ">Approved</span>
                                        @elseif($request->status === 'rejected')
                                            <span style="color: red;font-weight:bold">Rejected</span>
                                        @else
                                            <span style="color: rgb(203, 203, 94);font-weight:bold">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $request->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if($request->status === 'approved')
                                            <form action="{{ route('orders.create') }}" method="GET">
                                                <input type="hidden" name="purchase_request_id" value="{{ $request->id }}">
                                                <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        No purchase requests found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $requests->links() }}
            </div>
        </div>
    </main>
</x-app-layout>
