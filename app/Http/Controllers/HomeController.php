<?php

namespace App\Http\Controllers;

use App\Models\ContactUS;
use App\Models\Order;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {   
        return view("home.index");
    }

    public function showOrder(Request $request)
    {
        $orders =$request->user()

        ->orders()
        ->with([
            'car' => function ($query) {
                $query->select('id', 'maker_id', 'model_id','year','price')
                    ->with([
                        'maker:id,name',
                        'model:id,name',
                        'primaryImage:id,car_images.car_id,image_path',
                    ]);
            }
        ])
        ->orderBy("created_at",'desc')
        ->paginate(5);
        
        return view("car.order",['orders'=> $orders]);
    }
    public function showPendingPurchaseRequests()
    {
        $requests = PurchaseRequest::where('status', 'pending')
        ->whereHas('car', function ($query) {
            $query->where('owner_id', Auth::id());
        })
        ->with(['car', 'buyer'])
        ->orderBy('created_at', 'desc')
        ->paginate(3);

    return view('car.pending-purchase-requests', compact('requests'));
    }
    public function showCompletedOrders(Request $request)
    {
        $orders = Order::whereHas('car', function ($query) {
            $query->where('owner_id', Auth::id());
        })
        ->where('status', 'Paid')
        ->with([
            'car:id,owner_id,maker_id,model_id,year,price',
            'car.maker:id,name',
            'car.model:id,name',
            'car.primaryImage:id,car_images.car_id,image_path',
            'user:id,name'
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(3);
        

        return view('car.sales', compact('orders'));
    }
    public function approvePurchaseRequest(PurchaseRequest  $request)
    {
        // TO verify an this car related cuurent owner
        if ($request->car->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Chang the status of purchase to approved 
        $request->update(['status' => 'approved']);

        return redirect()->back()
        ->with('success', 'The purchase request has been approved. Waiting for buyer to pay.');
    }
    public function rejectPurchaseRequest(PurchaseRequest  $request)
    {
        // TO verify an this car related cuurent owner
        if ($request->car->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Chang the status of purchase to approved 
        $request->update(['status' => 'rejected']);

        return redirect()->back()
        ->with('success', 'The purchase request has been rejected.');
    }

    public function myRequests(Request $request)
{
    $requests = PurchaseRequest::where('buyer_id', $request->user()->id)
        ->with([ 
        'car.maker:id,name',
        'car.model:id,name',
        'car.primaryImage:id,car_images.car_id,image_path',])
        ->latest()
        ->paginate(4);

    return view('car.My Purchase Requests', compact('requests'));
}


     // This method To send a messag to admin 
    public function ContactStore(Request $request)
    {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'subject' => 'required|string|max:255',
                'message' => 'required|string'
            ]);
            ContactUS::create($data);
            return back()->with('success', 'The Message has been sent to admin. ');
    }


}
