<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminVenueController extends Controller
{
    public function index(Request $request)
    {
        $query = Venue::orderBy('id', 'desc');
        if ($request->venueSearch) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->venueSearch . '%')
                    ->where('slug', 'like', '%' . $request->venueSearch . '%');
            });
        }
        $venues = $query->paginate(10)->withQueryString();
        return Inertia::render('Admin/Venue/VenueIndex', [
            'venues' => $venues,
            'filters' => $request->only('venueSearch'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Venue/VenueCreate');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'city'          => 'required|string|max:100',
            'state'         => 'nullable|string|max:100',
            'country'       => 'nullable|string|max:100',
            'address'       => 'nullable|string',
            'capacity'      => 'nullable|integer|min:1',
            'status'        => 'nullable|in:0,1',
            'venuePhoto'    => 'nullable|file|mimes:jpeg,png|max:2048',
        ]);

        if ($request->hasFile('venuePhoto')) {
            $file = $request->file('venuePhoto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('venue-photos', $fileName, 'public');
        }

        Venue::create([
            'name'          => $request->name,
            'city'          => $request->city,
            'state'         => $request->state,
            'country'       => $request->country,
            'address'       => $request->address,
            'capacity'      => $request->capacity,
            'is_active'     => $request->status ?? false,
            'venue_image'   => $request->hasFile('venuePhoto') ? $filePath : null,
        ]);

        return redirect()->route('admin.venues.index')->with('message', 'Event venue created successfully.');
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
    public function edit(string $id)
    {
        $getVenue = Venue::findOrFail($id);
        return Inertia::render('Admin/Venue/VenueCreate', [
            'venue' => $getVenue,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venue $venue)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'status'      => 'nullable|in:0,1',
            'city'        => 'required|string|max:255',
            'state'       => 'required|string|max:255',
            'country'     => 'required|string|max:255',
            'capacity'    => 'required|integer|min:1',
            'address'     => 'required|string',
            'venuePhoto'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $filePath = $venue->venue_photo;

        if ($request->hasFile('venuePhoto')) {
            $file = $request->file('venuePhoto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('venue-photos', $fileName, 'public');
        }

        $venue->update([
            'name'        => $validated['name'],
            'is_active'   => $validated['status'], // 1 = active, 0 = inactive
            'city'        => $validated['city'],
            'state'       => $validated['state'],
            'country'     => $validated['country'],
            'capacity'    => $validated['capacity'],
            'address'     => $validated['address'],
            'venue_image' => $filePath,
        ]);

        return redirect()->route('admin.venues.index')->with('message', 'Event venue updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $getVenue = Venue::findOrFail($id);
        $getVenue->delete();
        return redirect()->route('admin.venues.index')->with('message', 'Event venue deleted successfully.');
    }
}
