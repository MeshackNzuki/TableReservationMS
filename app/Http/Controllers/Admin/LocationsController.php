<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationStoreRequest;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();
        return view('admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Location::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return to_route('admin.locations.index')->with('success', 'Location created successfully.');
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
    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $Location)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
       

        $Location->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return to_route('admin.locations.index')->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $Location)
    {
       
        $Location->delete();

        return to_route('admin.locations.index')->with('danger', 'Location deleted successfully.');
    }
}
