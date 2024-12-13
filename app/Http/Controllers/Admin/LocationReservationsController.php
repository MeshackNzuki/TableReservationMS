<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLocationReservationsRequest;
use App\Models\LocationReservations;
use App\Models\Location;
use App\Models\User;
use App\Models\Table;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LocationReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = LocationReservations::whereDate('res_date', '>=', Carbon::today()->toDateString())->where('cancel', 0)->orderBy('res_date')->get();

        $search = "0";

        return view('admin.locationReservations.index', compact('reservations', 'search'));
    }

    public function history()
    {
        $reservations = LocationReservations::orderBy('res_date')->get();

        $search = "0";

        return view('admin.locationReservations.reservationHistory', compact('reservations', 'search'));
    }
    /**
     * Show the form for creating a new resource.
     */

    public function search(Request $request)
    {

        $date = $request->input('date');


        $reservations = LocationReservations::whereDate('res_date', '>=', Carbon::today()->toDateString())->where('cancel', 0)->when($date, function ($query) use ($date) {

            $carbonDate = Carbon::parse($date)->startOfDay();

            return $query->whereDate('res_date', '=', $carbonDate);
        })->get();

        $search = "1";

        return view('admin.reservations.index', compact('reservations', 'search'));
    }
    public function create()
    {
        $tables = Table::all();
        return view('admin.locationReservations.create', compact('tables'));
    }

    public function searchHistory(Request $request)
    {
        $date = $request->input('date');

        $reservations = LocationReservations::when($date, function ($query) use ($date) {

            $carbonDate = Carbon::parse($date)->startOfDay();

            return $query->whereDate('res_date', '=', $carbonDate);
        })->get();

        $search = "1";

        return view('admin.locationReservations.reservationHistory', compact('reservations', 'search'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $location = Location::findOrFail($request->location_id);
    
        $request_date = Carbon::parse($request->res_date);
    
        $locationreservations = LocationReservations::where('location_id', $request->location_id) ->where('cancel', 0)->get();
    
        foreach ($locationreservations as $res) {
            // Check if the reservation date matches the request date
            if ($res->res_date->format('Y-m-d') == $request_date->format('Y-m-d')) {
                // Convert reservation start and end times to Carbon objects
                $existingStartTime = Carbon::parse($res->res_date);
                $existingEndTime = Carbon::parse($res->checkout_date);
    
                // Convert request start and end times to Carbon objects
                $request_res_date = Carbon::parse($request->res_date);
                $request_checkout_date = Carbon::parse($request->checkout_date);    
                // Check if the requested time range overlaps with the existing reservation time range
                if (
                    $request_res_date->between($existingStartTime, $existingEndTime) ||
                    $request_checkout_date->between($existingStartTime, $existingEndTime)
                ) {
                    return back()->with('warning', $location->name . ' is fully reserved for date ' . $request_res_date->format('Y-m-d H:i')  . ' - ' . $request_checkout_date->format(' H:i '))->withInput();
                }
            }
        }
    
        $dayOfWeek = $request_date->englishDayOfWeek;
        $time = $request_date->format('H:i');
    
        // Extract necessary data for reservation
        $reservationData = $request->only([
            'res_date', 
            'checkout_date', 
            'guest_number', 
            'location_id'
        ]);
    


        $clientPhoneNumber = $request->tel_number;

        // Make copies of the original phone number
        $clientPhoneNumberWithCode = $clientPhoneNumber;
        $clientPhoneNumberWithoutCode = $clientPhoneNumber;
        
        // Check if the phone number does not start with a '+'
        if (substr($clientPhoneNumberWithCode, 0, 1) !== '+') {
            // If not, prepend the Kenyan country code "+254" and remove any leading zero
            $clientPhoneNumberWithCode = '+254' . ltrim($clientPhoneNumberWithCode, '0');
        } else {
            // If it starts with a '+', remove the country code to convert it to a local number           
            $clientPhoneNumberWithoutCode = substr($clientPhoneNumberWithoutCode, -9); // Get the last 9 digits
            // Add a leading zero to the local number
            $clientPhoneNumberWithoutCode = '0' . $clientPhoneNumberWithoutCode;
        }
        

        // Query the User model to find a user with either phone number format
        $user = User::where('tel_number', $clientPhoneNumberWithCode)->first();

        // If no user is found with the phone number including the country code, fallback to searching by local number
        if (!$user) {
            $user = User::where('tel_number', $clientPhoneNumberWithoutCode)->first();
        }
    
        // If user exists, set user_id in reservation data
        if ($user) {
            $reservationData['user_id'] = $user->id;
        } else {
            // If user doesn't exist, create a new user record
            $newUser = User::create([
                'name' => $request->input('name'),
                'tel_number' => $request->tel_number,
                'email' => $request->input('email'),
            ]);
    
            // Set user_id in reservation data to the id of the newly created user
            $reservationData['user_id'] = $newUser->id;
        }

        // Check if the reservation is recurring
        if ($request->has('recurring')) {
            $reservationData['day_of_week'] = $dayOfWeek;
            $reservationData['recur_time'] = $time;
            $reservationData['recurring'] = 1;
        }

        $uniqueIdentifier = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
        $prefix = 'RES-';    
        $reservationRefNumber = $prefix . $uniqueIdentifier;
        $reservationData['ref'] = $reservationRefNumber;
       

        // Create the reservation
        LocationReservations::create($reservationData);

        try {
            //send a whatsapp message
              $sid = env('TWILIO_SID');
              $token = env('TWILIO_TOKEN');
              $twilio = new Client($sid, $token);    
        
             $message = $twilio->messages
              ->create("whatsapp:".(string)$clientPhoneNumberWithCode,
              array(              
                "from" => "whatsapp:".env('TWILIO_FROM'),
                'body' => "Dear " . User::where('id', $reservationData['user_id'])->value('name') . ', your reservation at Rolling Stones Eatery for ' . \Carbon\Carbon::parse($reservationData['res_date'])->format('l, F j, Y \a\t g:i A') .  ' has been confirmed. Your reservation reference number is ' .$reservationData['ref'] . '.  We look forward to seeing you soon!'
            )            
              );
        } catch (\Throwable $th) {
            //throw $th;
        }
    
        return redirect()->route('admin.locationreservations.index')
            ->with('success', 'Reservation created successfully.');
    }    

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id = $request->id;

        if ($id) {
            $reservations = Reservation::where('id', $id)->get();
            return view('admin.locationReservations.viewReservation', compact('reservations'));
        } else {
            // Handle the case where no ID is provided
            return view('admin.locationReservations.viewReservation', ['reservations' => []]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */

     public function cancel(Request $request, $id)
{

    // Find the reservation by ID
    $reservation = LocationReservations::find($id);

    // Check if the reservation exists
    if (!$reservation) {
        return response()->json([
            'message' => 'Reservation not found',
        ], 404);
    }

    // Toggle the 'cancel' field
    $reservation->cancel = !$reservation->cancel;

    // Save the changes to the database
    $reservation->save();

    // Return a success response
    return redirect()->route('admin.locationreservations.index')
            ->with('success', 'Reservation cancelled successfully.');
}

    public function edit(LocationReservations $locationreservation)
    {
        $reservation =  $locationreservation;
        $tables = Table::where('status', TableStatus::Available)->get();
        return view('admin.locationReservations.edit', compact('reservation', 'tables'));
    }

    public function update(Request $request, $locationreservation)
    {
        // // Validate the request
        
        // $validator = Validator::make($request->all(), [
        //     'first_name' => ['required'],
        //     'last_name' => ['required'],
        //     'res_date' => ['required', 'date'],
        //     'checkout_date' => ['required', 'date'],
        //     'tel_number' => ['required'],
        //     'location_id' => ['required', 'exists:locations,id'],
        //     'guest_number' => ['required', 'integer', 'min:1'],
        // ]);
    
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
    
        // Find the location

        $location = Location::findOrFail($request->location_id);
        $requestResDate = Carbon::parse($request->res_date);
        $requestCheckoutDate = Carbon::parse($request->checkout_date);
    
        // Retrieve the reservation being updated
        $reservation = LocationReservations::findOrFail($locationreservation);
        $user= $reservation->user;
        $user->name = $request->name;
        if (isset($request->tel_number) && strlen($request->tel_number) > 11) {
            $user->tel_number = $request->tel_number;
        }
        $user->save();
    
        // Retrieve conflicting reservations
        $conflictingReservations = LocationReservations::where('location_id', $request->location_id)
            ->where('id', '!=', $locationreservation)
            ->get();
    
        foreach ($conflictingReservations as $conflict) {
            $conflictResDate = Carbon::parse($conflict->res_date);
            $conflictCheckoutDate = Carbon::parse($conflict->checkout_date);
    
            if (
                ($requestResDate->between($conflictResDate, $conflictCheckoutDate) || 
                 $requestCheckoutDate->between($conflictResDate, $conflictCheckoutDate)) ||
                ($conflictResDate->between($requestResDate, $requestCheckoutDate) || 
                 $conflictCheckoutDate->between($requestResDate, $requestCheckoutDate))
            ) {
                return redirect()->route('admin.locationreservations.index')->with('warning', $location->name . ' has an existing reservation during that time.');
            }
        }
    
        // Prepare data to update
        $reservationData = $request->all();
    
        // Update the reservation
        $reservation->update($reservationData);
    
        return redirect()->route('admin.locationreservations.index')->with('success', 'Reservation updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request)
    {
        // Find the location reservation
        $locationReservation = LocationReservations::findOrFail($request->id);

        // Delete the location reservation
        $locationReservation->delete();

        // Redirect back with success message
        return back()->with('success', 'Reservation deleted successfully');
    }
}