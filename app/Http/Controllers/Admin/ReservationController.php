<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationStoreRequest;
use App\Models\Reservation;
use App\Models\LocationReservations;
use App\Models\Table;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Twilio\Rest\Client;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::whereDate('res_date', '>=', Carbon::today()->toDateString())->where('cancel', 0)->orderBy('res_date')->get();
        $search = "0";
        return view('admin.reservations.index', compact('reservations', 'search'));
    }

    
    public function recurring_index()
    {
        $reservations = Reservation::where('cancel', 0)->where('recurring',1)->orderBy('res_date')->get();
        $locationreservations = LocationReservations::where('cancel', 0)->where('recurring',1)->orderBy('res_date')->get();
        $search = "0";
        return view('admin.recurring.index', compact('reservations', 'search','locationreservations'));
    }

    public function history()
    {
        $reservations = Reservation::orderBy('res_date')->get();
        $search = "0";
        return view('admin.reservations.reservationHistory', compact('reservations', 'search'));
    }

    public function search(Request $request)
    {

        $date = $request->input('date');


        $reservations = Reservation::whereDate('res_date', '>=', Carbon::today()->toDateString())->where('cancel', 0)->when($date, function ($query) use ($date) {

            $carbonDate = Carbon::parse($date)->startOfDay();

            return $query->whereDate('res_date', '=', $carbonDate);
        })->get();

        $search = "1";

        return view('admin.reservations.index', compact('reservations', 'search'));
    }



    public function searchHistory(Request $request)
    {

        $date = $request->input('date');


        $reservations = Reservation::when($date, function ($query) use ($date) {

            $carbonDate = Carbon::parse($date)->startOfDay();

            return $query->whereDate('res_date', '=', $carbonDate);
        })->get();

        $search = "1";

        return view('admin.reservations.reservationHistory', compact('reservations', 'search'));
    }



    public function create()
    {

        $currentDateTime = \Carbon\Carbon::now();


        $tables = \App\Models\Table::all();

        return view('admin.reservations.create', compact('tables'));
    }


    public function store(Request $request)
    {
        $table = Table::findOrFail($request->table_id);

        $request_date = Carbon::parse($request->res_date);

        $requestStartDate = Carbon::parse($request->res_date);

        $requestEndDate = Carbon::parse($request->checkout_date);

        $locationreservations = LocationReservations::where('location_id', $table->location->id)->get();


        // Get the location to which the table belongs
        $location = $table->location;

        // Check if there are any reservations for the location on the requested date and time
        $locationReservations = LocationReservations::where('location_id', $location->id)
        ->where('cancel', 0)
        ->where(function ($query) use ($requestStartDate, $requestEndDate) {
            $query->whereBetween('res_date', [$requestStartDate, $requestEndDate])
                ->orWhereBetween('checkout_date', [$requestStartDate, $requestEndDate]);
        })
        ->exists();

        // If there are reservations for the location, return a warning message
        if ($locationReservations) {
            return back()->with('warning', $location->name . ' is fully reserved for date ' . $request_date->format('Y-m-d H:i') . ' - ' . $requestEndDate->format(' H:i '))->withInput();
        }


        //check if booking also exists in areas table
        foreach (Reservation::where('table_id',$request->table_id)->where('cancel', 0)->get() as $res) {
              
                // Convert reservation start and end times to Carbon objects
                $existingStartTime = Carbon::parse($res->res_date);
                $existingEndTime = Carbon::parse($res->checkout_date);
    
                // Check if the requested time range overlaps with the existing reservation time range
                if (
                    $requestStartDate->between($existingStartTime, $existingEndTime) ||
                    $requestEndDate->between($existingStartTime, $existingEndTime)
                ) {                
                     return back()->with('warning', $table->name . ' in ' .$table->location->name . ' is reserved for date ' . $requestStartDate->format('Y-m-d H:i')  . ' - ' . $requestEndDate->format(' H:i '))->withInput();
                }
            
        }


        $dayOfWeek = $request_date->englishDayOfWeek;

        $time = $request_date->format('H:i');


        $reservationData = $request->all();


        //from reservations get  {name,tel_number,email   then create auser_id to ref}  but if the user exists in users table just insert its id in user_id

        $clientPhoneNumber = $reservationData['tel_number'];

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
                'name' => $reservationData['name'],
                'tel_number' => $reservationData['tel_number'],
                'email' => $reservationData['email'],
            ]);

            // Set user_id in reservation data to the id of the newly created user
            $reservationData['user_id'] = $newUser->id;
        }



        if ($request->has('recurring')) {

            $reservationData['day_of_week'] = $dayOfWeek;
            $reservationData['recur_time'] = $time;
            $reservationData['recurring'] = 1;
        }


        //input ref number

        $uniqueIdentifier = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
        $prefix = 'RES-';    
        $reservationRefNumber = $prefix . $uniqueIdentifier;
        $reservationData['ref'] = $reservationRefNumber;

        Reservation::create($reservationData);

        try {
            //send a whatsapp message
              $sid = env('TWILIO_SID');
              $token = env('TWILIO_TOKEN');
              $twilio = new Client($sid, $token);    
        
             $message = $twilio->messages
              ->create("whatsapp:".$clientPhoneNumberWithCode,
              array(              
                "from" => "whatsapp:".env('TWILIO_FROM'),
                'body' => "Dear " . User::where('id', $reservationData['user_id'])->value('name') . ', your reservation at Rolling Stones Eatery for ' . \Carbon\Carbon::parse($reservationData['res_date'])->format('l, F j, Y \a\t g:i A') .  ' has been confirmed. Your reservation reference number is ' .$reservationData['ref'] . '. We look forward to seeing you soon!'
            )            
              );
        } catch (\Throwable $th) {
           // throw $th;
        }
         
        return redirect()
            ->route('admin.reservations.index')
            ->with('success', 'Reservation created successfully.');
    }

    public function show(Request $request, $ids = null)
    {
        $today = Carbon::today();
    
        if ($ids) {
            $reservationIds = explode(',', $ids);
            $reservations = Reservation::whereIn('id', $reservationIds)
                                       ->whereDate('res_date', $today)
                                       ->get();
        } else {
            // return empty
            $reservations = [];
        }
    
        return view('admin.reservations.viewReservation', compact('reservations'));
    }
    

    public function cancel(Request $request, $id)
    {
        // Find the reservation by ID
        $reservation = Reservation::find($id);
    
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

        try {
              //send a whatsapp message
              $sid = env('TWILIO_SID');
              $token = env('TWILIO_TOKEN');
              $twilio = new Client($sid, $token);
        
            $message = $twilio->messages       
            ->create("whatsapp:+254" . ltrim(User::where('id', $reservation->user_id)->value('tel_number'), '0'),
              array(             
                "from" => "whatsapp:".env('TWILIO_FROM'),
                'body' => "Dear " . User::where('id', $reservation->user_id)->value('name') . ', Your reservation at Rolling Stones Eatery for ' . \Carbon\Carbon::parse($reservationData['res_date'])->format('l, F j, Y \a\t g:i A') .  ' has been cancelled as requested. We look forward to seeing you soon!'
            )            
              );
        } catch (\Throwable $th) {
            //throw $th;
        }

           
    
        // Return a success response
        return redirect()->route('admin.reservations.index')
        ->with('success', 'Reservation cancelled successfully.');
    }


    public function edit(Reservation $reservation)
    {

        $tables = Table::where('status', TableStatus::Available)->get();
        return view('admin.reservations.edit', compact('reservation', 'tables'));
    }
    public function update(Request $request, $id)
{
    // Validate the request if needed
    $request->validate([
        'table_id' => 'required|exists:tables,id',
        'guest_number' => 'required|integer|min:1',
        'res_date' => 'required|date',
        'checkout_date' => 'required|date|after_or_equal:res_date',
        'tel_number' => 'required',        
        'name' => 'required|string',
    ]);

   

    // Find the table
    $table = Table::findOrFail($request->table_id);

    // Check if the guest number exceeds the table's capacity
    if ($request->guest_number > $table->guest_number) {
        return back()->with('warning', 'Please choose the table based on guests.');
    }

    // Retrieve the reservation being updated
    $reservation = Reservation::findOrFail($id);
    $user= $reservation->user;
    $user->name = $request->name;
    if (isset($request->tel_number) && strlen($request->tel_number) > 11) {
        $user->tel_number = $request->tel_number;
    }
    
    $user->save();
  

    $requestResDate = Carbon::parse($request->res_date);
    $requestCheckoutDate = Carbon::parse($request->checkout_date);

    // Check for conflicts with other reservations on the same date and time range
    $conflictingReservations = Reservation::where('table_id', $request->table_id)
        ->where('id', '!=', $id)->where('cancel' , 0) // Exclude the current reservation being updated
        ->get();

    foreach ($conflictingReservations as $conflictingReservation) {
        $conflictResDate = Carbon::parse($conflictingReservation->res_date);
        $conflictCheckoutDate = Carbon::parse($conflictingReservation->checkout_date);

        if (
            ($requestResDate->between($conflictResDate, $conflictCheckoutDate) || 
             $requestCheckoutDate->between($conflictResDate, $conflictCheckoutDate)) ||
            ($conflictResDate->between($requestResDate, $requestCheckoutDate) || 
             $conflictCheckoutDate->between($requestResDate, $requestCheckoutDate))
        ) {
            return redirect()->route('admin.reservations.index')->with('warning', 'This reservation has conflicts with existing reservations.');
        }
    }

    // Prepare data to update
    $reservationData = $request->all();

    // Update the reservation
    $reservation->update($reservationData);

    return redirect()->route('admin.reservations.index')->with('success', 'Reservation updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return to_route('admin.reservations.index')->with('success', 'Reservation deleted successfully');
    }
}