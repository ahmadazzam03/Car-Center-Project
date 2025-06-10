<?php
namespace App\Http\Controllers;
use App\Models\Car;
use App\Models\Order;
use App\Models\PurchaseRequest;
use App\Models\User;
use App\Http\Requests\StorCarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $cars = Car::where('owner_id', $userId)
        ->with([
            'primaryImage:id,car_images.car_id,image_path',
            'maker:id,name',
            'model:id,name',
            'owner:id,name'
        ])
        ->withCount('ratings')
        ->withAvg('ratings','rating')
        ->orderBy('created_at', 'desc')
        ->paginate(5);

    return view('car.index', ['cars' => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('create',Car::class))
        {
            return redirect()->route('profile.index')
        ->with('warning','Pleaze provide phone number');
        }
        return view("car.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorCarRequest $request)
    {
        Gate::authorize('create',Car::class);
        //get all request data from form and validate it's
        $data = $request->validated();
        $featuresData = $data['features'];
        // Get images
        $images = $request->file('images')?:[];
        $data['owner_id']=Auth::id();
        $data['phone'] = User::find(Auth::id())->phone;
        $data['published_at'] = Carbon::now();
        $car = Car::create($data);
        $car->features()->create($featuresData);
        // Iterate and create images
        foreach($images as $i => $image)
        {
            // Save image on file system
            $path = $image->store('images','public');
            $car->images()->create(['image_path'=>$path,'position'=>$i+1]);
        }
        return redirect()->back()->with('success','Car was created, Pleaze wait untill admin accept it.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)//route model binding
    {
        abort_if($car->status !== 'Approved', 404);

        $user = Auth::user();
        $cacheKey = "car_details_{$car->id}";

        $car = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($car) {
            return $car->load([
            'city.state',
            'carType',
            'fuelType',
            'maker',
            'model',
            'owner',
            'images',
            'features',
            
            ])
            ->loadCount('ratings')
            ->loadAvg('ratings','rating');
        });
        $userRating = $user ? $car->ratings->where('user_id', $user->id)->first() : null;

        return view("car.show",['car'=>$car , 'userRating' => $userRating]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)//route model binding
    {
        //To prevent users from opening or editing, or deleting cars that belong to other users, let’s add security checks.
        //User will only be able to open car edit window if the user is the owner of the car
        Gate::authorize('update',$car);
        return view("car.edit",['car'=>$car]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorCarRequest $request, Car $car)//route model binding
    {

        //To prevent users from opening or editing, or deleting cars that belong to other users, let’s add security checks.
        //User will only be able to open car edit window if the user is the owner of the car
        Gate::authorize('update',$car);

        // Get validated data from request
        $data = $request->validated(); 
        // Get features from the data
        $features = array_merge([
            'abs' => 0,
            'air_conditioning' => 0,
            'power_windows' => 0,
            'power_door_locks' => 0,
            'cruise_control' => 0,
            'bluetooth_connectivity' => 0,
            'remote_start' => 0,
            'gps_navigation' => 0,
            'heater_seats' => 0,
            'climate_control' => 0,
            'rear_parking_sensors' => 0,
            'leather_seats' => 0,
        ], $data['features'] ?? []);//if doesn't exisits we store empty array

        // Update car details
        $car->update($data);

        //update car features
        $car->features()->update($features); 

        Cache::forget('car_details_' . $car->id);
        Cache::forget('car_phone_' . $car->id);

        return redirect()->route('car.index')
        ->with('success','Car was updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)//route model binding
    {
        //To prevent users from opening or editing, or deleting cars that belong to other users, let’s add security checks.
        //User will only be able to open car edit window if the user is the owner of the car
        Gate::authorize('delete', $car);

        $car->delete();

        Cache::forget('car_details_' . $car->id);

        return redirect()->route('car.index')
        ->with('success','Car was deleted');
    }

    // This method to filter a car by specific criteria in the form request
    public function search(Request $request)
    {
        // In the First we need to collect all the request data from request
        $maker = $request->integer('maker_id');  
        $model = $request->integer('model_id');  
        $carType = $request->integer('car_type_id');  
        $fuelType = $request->integer('fuel_type_id');  
        $state = $request->integer('state_id');  
        $city = $request->integer('city_id');  
        $yearFrom = $request->integer('year_from');  
        $yearTo = $request->integer('year_to');  
        $priceFrom = $request->integer('price_from');  
        $priceTo = $request->integer('price_to');  
        $mileage = $request->integer('mileage');  
        $sort = $request->input('sort','-published_at');  
        //to get all the cars which are status is approved 
        $query = Car::where('status','Approved')
        //We use the eager loading to reduce the overhead on website 
        ->with([
        'primaryImage:id,car_images.car_id,image_path',
        'city.state',
        'maker:id,name',
        'model:id,name',
        'carType',
        'fuelType',
        'favouredUsers',
        ])
        ->withAvg('ratings','rating')
        ->withCount('ratings');
        //then arrangment it in desc order by published_at coulmn 

        //apply filtering on $query
        if($maker)
        {
            $query->where('maker_id',$maker); 
        }
        if($model)
        {
            $query->where('model_id',$model); 
        }
        if($state)
        {
            $query->join('cities','cities.id','=','cars.city_id')
            ->where('cities.states_id',$state);   
        }
        if($city)
        {
            $query->where('city_id',$city); 
        }
        if($carType)
        {
            $query->where('car_type_id',$carType); 
        }
        if($fuelType)
        {
            $query->where('fuel_type_id',$fuelType); 
        }
        if($yearFrom)
        {
            $query->where('year','>=',$yearFrom); 
        }
        if($yearTo)
        {
            $query->where('year','<=',$yearTo); 
        }
        if($priceFrom)
        {
            $query->where('price','>=',$priceFrom); 
        }
        if($priceTo)
        {
            $query->where('price','<=',$priceTo); 
        }
        if($mileage)
        {
            $query->where('mileage','>=',$mileage); 
        }

        if(str_starts_with($sort,'-'))
        {
            $sort = substr($sort,1);
            $query->orderBy($sort,'desc'); 
        }
        else 
        {
            $query->orderBy($sort);
        }
        //to do paginate for cars 
        $cacheKey = 'search_results_' . md5(serialize($request->all()));
        $cars = Cache::remember($cacheKey, 3600, function () use ($query) {
            return $query->paginate(6)->withQueryString();
        });
        
        return view("car.search",['cars'=>$cars]);
    }

    public function carImages(Car $car)
    {
        Gate::authorize('update',$car);
        $cacheKey = 'car_images_' . $car->id;
        $images = Cache::remember($cacheKey, 60, function () use ($car) {
            return $car->images()->orderBy('position')->get();
        });
        return view('car.images',['car' => $car]);
    }

    public function updateImages(Request $request,Car $car)
    {
        //To prevent users from opening or editing, or deleting cars that belong to other users, let’s add security checks.
        //User will only be able to open car edit window if the user is the owner of the car
        Gate::authorize('update',$car);

        // Get Validated data of delete images and positions
        $data = $request->validate([
            'delete_images' => 'array',
            'delete_images.*' => 'integer',
            'positions' => 'array',
            'positions.*' => 'integer'
        ]);

        $deleteImages = $data['delete_images'] ?? []; 
        $positions = $data['positions']??[];

        // Select images to delete
        $imagesToDelete = $car->images()->whereIn('id', $deleteImages)->get();
        // Iterate over images to delete and delete them from file system
        foreach($imagesToDelete as $image)
        {
            if(Storage::exists($image->image_path))
            {
                Storage::delete($image->image_path);
            }
        }
        // Delete images from the database
        $car->images()->whereIn('id', $deleteImages)->delete();

        Cache::forget('car_images_' . $car->id);

        // Iterate over positions and update position for each image, by its ID
        foreach ($positions as $id => $position) {
            $car->images()->where('id', $id)->update(['position' => $position]);
        }

        // Redirect back to car.images route
        return redirect()->back()
        ->with('success','Car Images were updated');
    }
    public function addImages(Request $request,Car $car)
    {
        //To prevent users from opening or editing, or deleting cars that belong to other users, let’s add security checks.
        //User will only be able to open car edit window if the user is the owner of the car
        Gate::authorize('update',$car);

        // Get images from request
        $images = $request->file('images') ?? [];

        // Select max position of car images
        $position = $car->images()->max('position') ?? 0;
        foreach ($images as $image) {
        // Save it on the file system
        $path = $image->store('images','public');
        // Save it in the database
        $car->images()->create([
            'image_path' => $path,
            'position' => $position + 1
        ]);
        $position++;
    }

        Cache::forget('car_images_' . $car->id);

    return redirect()->back()
    ->with('success','New Images were added');
    }
    public function showPhone(Car $car)
    {
        $cacheKey = 'car_phone_' . $car->id;
        $phone = Cache::remember($cacheKey, 60, function () use ($car) {
            return $car->phone;
        });

        return response()->json(['phone' => $car->phone]);
    }

    public function createOrder(Request $request)
    {
        $purchaseRequestId = $request->input('purchase_request_id');


        $purchaseRequest = PurchaseRequest::with(
             'car.maker:id,name',
                        'car.model:id,name',
                        'car.primaryImage:id,car_images.car_id,image_path',)
        ->where('id', $purchaseRequestId)
        ->where('buyer_id', auth()->id())
        ->where('status', 'approved')
        ->firstOrFail();
        
        return view('car.checkout',[
            'purchaseRequest' => $purchaseRequest,
        ]);
    }
    public function storeOrder(Request $request)
    {
        $data = $request->validate([
            'purchase_request_id' => 'required|exists:purchase_requests,id',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|size:6',
            'card_name' => 'required|string|max:255',
            'cridt_card_number' => 'required|string|size:19',
            function ($attribute, $value, $fail) {
                $cleanedValue = str_replace(' ', '', $value);
                if (strlen($cleanedValue) !== 16 || !ctype_digit($cleanedValue)) {
                    $fail('The credit card number must be 16 digits.');
                }
            },
            'cvv' => 'required|string|size:4'
        ]);
        
        $cridtCardNumber = str_replace(' ', '', $request->input('cridt_card_number'));

        $purchaseRequest = PurchaseRequest::with('car')
        ->where('id', $data['purchase_request_id'])
        ->where('buyer_id', auth()->id())
        ->where('status', 'approved')
        ->firstOrFail();

        $order = Order::create([
            'user_id' => auth()->id(), 
            'car_id' => $purchaseRequest->car_id,
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip_code' => $data['zip_code'],
            'card_name' => $data['card_name'],
            'card_number' => $cridtCardNumber,
            'cvv' => $data['cvv'],
            'status' => 'Paid', 
        ]);

        $purchaseRequest->car->update(['status' => 'Sold']);

        $purchaseRequest->delete();

        return redirect()->route('car.order')
        ->with('success', 'Payment completed and order placed.');
    }

    public function storePurchaseRequest(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
        ]);
        

        $car = Car::findOrFail($request->car_id);

        if (auth()->id() == $car->owner_id) {
            return back()->withErrors('You cannot request to buy your own car.');
        }

        PurchaseRequest::create([
            'car_id' => $car->id,
            'buyer_id' => auth()->id(),
            'status' => 'pending', 
        ]);

        return redirect()->route('car.show', $car)->with('success', 'Purchase request sent to the owner for approval.');
    }

}
