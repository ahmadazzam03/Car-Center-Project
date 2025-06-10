<x-app-layout title="Purchase Requests" bodyClass="page-my-cars">
    <main style="margin-top:80px">
        <div class="container" >
            
            <h1 class="page-title">Your Car Purchase Requests</h1>
            <div class="card p-medium">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Car Image</th>
                                <th>Car Deatil </th>
                                <th>price</th>
                                <th>Created At</th>
                                <th>Buyer</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $request)
                                <tr>
                                    <td>
                                        <img
                                            src="{{$request->car->primaryImage?->getUrl() ?: '/img/no-image.png'}}" 
                                            class="my-cars-img-thumbnail"
                                            style="display: flex;padding:8px;width:110px"
                                            loading="lazy"/>
                                    </td>
                                    <td>{{$request->car->year}} - {{$request->car->maker->name}} - {{$request->car->model->name}}</td>
                                    <td>{{$request->car->price}} JOD</td>
                                    <td>{{ $request->created_at->format('d M Y') }}</td>
                                    <td>{{ $request->buyer->name }}</td>
                                    <td>{{ $request->status }}</td>

                                    @if($request->status === 'pending')
                                    <td style="display:flex;margin:10px">
                                    <form 
                                            id="approve-request-form-{{ $request->id }}"
                                            action="{{ route('purchase-requests.approve', $request->id) }}"
                                            method="POST"
                                            class="inline-flex">
                                            @csrf
                                            <button 
                                            type="button" 
                                            onclick="confirmApprove({{ $request->id }})" 
                                            class="btn inline-flex items-center" 
                                            style="margin-right:10px;background-color:green;color:white">
                                            Approve
                                            </button>
                                    </form>

                                    <form 
                                            id="decline-request-form-{{ $request->id }}"
                                            action="{{route('purchase-requests.reject',$request->id)}}"
                                            method="POST"
                                            class="inline-flex">
                                            @csrf
                                            <button
                                            type="button"
                                            onclick="confirmDecline({{ $request->id }})" 
                                            class="btn inline-flex items-center" 
                                            style="background-color: rgb(212, 10, 10);color:white">
                                            Reject
                                            </button>
                                    </form>

                                    <script>
                                        function confirmApprove(requestId) {
                                            Swal.fire({
                                                title: "Are you sure?",
                                                text: "You want to approve this request!",
                                                icon: "success",
                                                showCancelButton: true,
                                                confirmButtonColor: "#28a745",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Yes, approve it!"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    document.getElementById('approve-request-form-' + requestId).submit();
                                                }
                                            });
                                        }
                                    
                                        function confirmDecline(requestId) {
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
                                                    document.getElementById('decline-request-form-' + requestId).submit();
                                                }
                                            });
                                        }
                                    </script>
                                    </td>
                                    @endif
                                </tr>
                            @empty
                                <div class="text-center p-large">
                                    No incoming requests.
                                </div>

                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $requests->links() }} 
            </div>
        </div>
    </main>
</x-app-layout>