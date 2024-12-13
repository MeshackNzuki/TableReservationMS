<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TableStoreRequest;
use App\Models\Table;
use App\Models\Location;
use App\Models\Reservation;
use App\Models\LocationReservations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function dashboard()
    {
        $tables = Table::all();
        $startdate =  null;
        $enddate =  null;
        $filter = '0';
        

                    $total_customers = User::where('is_admin', 0)->count();
                    
                    $total_bookings = Reservation::count() + LocationReservations::count();
                    
                    $todays_bookings = Reservation::whereDate('res_date', Carbon::today())->count()  + LocationReservations::whereDate('res_date', Carbon::today())->count(); ;
                    
                    $upcoming_bookings = Reservation::whereDate('res_date', '>', Carbon::today())->count() ;

                    + LocationReservations::whereDate('res_date', '>', Carbon::today())->count();
     
               return view('admin.index', compact('tables', 'filter', 'startdate', 'enddate','total_customers', 'total_bookings', 'todays_bookings', 'upcoming_bookings'));
    }

    public function filter(Request $request)
    {
        $tables = Table::all();

        // Parse start and end dates using Carbon
        $startdate = Carbon::parse($request->input('start_date'));
        $enddate = Carbon::parse($request->input('end_date'));


        $filter = '1';

      
                    $total_customers = User::count();
                    
                    $total_bookings = Reservation::count() + LocationReservations::count();
                    
                    $todays_bookings = Reservation::whereDate('res_date', Carbon::today())->count() ;
                    
                    $upcoming_bookings = Reservation::whereDate('res_date', '>', Carbon::today())->count() ;

                    + LocationReservations::whereDate('res_date', '>', Carbon::today())->count();
     
               return view('admin.index', compact('tables', 'filter', 'startdate', 'enddate','total_customers', 'total_bookings', 'todays_bookings', 'upcoming_bookings'));
    }




    public function index()
    {
        $tables = Table::all();
        return view('admin.tables.index', compact('tables'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = DB::table('locations')->get();
        return view('admin.tables.create', compact('locations'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TableStoreRequest $request)
    {
        Table::create([
            'name' => $request->name,
            'guest_number' => $request->guest_number,
            'status' => $request->status,
            'location_id' => $request->location,
        ]);

        return to_route('admin.tables.index')->with('success', 'Table created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        $locations = Location::all();
        return view('admin.tables.edit', compact('table', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TableStoreRequest $request, Table $table)
    {
        $table->update($request->validated());

        return to_route('admin.tables.index')->with('success', 'Table updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        $table->reservations()->delete();
        $table->delete();

        return to_route('admin.tables.index')->with('success', 'Table updated successfully.');
    }
}