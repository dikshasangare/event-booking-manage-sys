<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Category;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::with(['venue', 'category'])->orderBy('id', 'desc');
        // ->where('status', 'published')
        if ($request->eventSearch) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->eventSearch . '%');
            });
        }
        $events = $query->latest()->paginate(10)->withQueryString();
        return Inertia::render('Admin/Event/EventIndex', [
            'events' => $events,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Event/EventCreate', [
            'venues'     => Venue::select('id', 'name')->get(),
            'categories' => Category::select('id', 'name')->get(),
            'artists'    => Artist::select('id', 'name', 'primary_role')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'venue_id'              => 'nullable|exists:venues,id',
            'category_id'           => 'required|exists:categories,id',
            'title'                 => 'required|string',
            'short_description'     => 'nullable|string',
            'about_event'           => 'nullable|string',
            'event_type'            => 'required|string',
            'age_limit'             => 'nullable|integer',
            'language'              => 'nullable|string',
            'start_datetime'        => 'required|date',
            'end_datetime'          => 'required|date|after:start_datetime',
            'banner_image'          => 'nullable|image',
            'artists'               => 'array',
            'artists.*.id'          => 'exists:artists,id',
            'artists.*.event_role'  => 'nullable|string',
        ]);

        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['banner_image'] = $file->storeAs('event-photos', $fileName, 'public');
        }

        $data['organizer_id'] = Auth::id();
        $event = Event::create($data);

        // Attach artists
        if ($request->artists) {
            $syncData = [];
            foreach ($request->artists as $artist) {
                $syncData[$artist['id']] = ['event_role' => $artist['event_role']];
            }
            $event->artists()->sync($syncData);
        }

        return redirect()->route('admin.events.index')->with('message', 'Event created');
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
        $event = Event::with(['venue', 'category'])->findOrFail($id);
        return Inertia::render('Admin/Event/EventCreate', [
            'event' => $event,
            'venues'     => Venue::select('id', 'name')->get(),
            'categories' => Category::select('id', 'name')->get(),
            'artists'    => Artist::select('id', 'name', 'primary_role')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);
        $validated = $request->validate([
            'venue_id'              => 'nullable|exists:venues,id',
            'category_id'           => 'required|exists:categories,id',
            'title'                 => 'required|string',
            'short_description'     => 'nullable|string',
            'about_event'           => 'nullable|string',
            'event_type'            => 'required|string',
            'age_limit'             => 'nullable|integer',
            'language'              => 'nullable|string',
            'start_datetime'        => 'required|date',
            'end_datetime'          => 'required|date|after:start_datetime',
            'banner_image'          => 'nullable|image',
            'artists'               => 'array',
            'artists.*.id'          => 'exists:artists,id',
            'artists.*.event_role'  => 'nullable|string',
        ]);

        $validated['banner_image'] = $event->banner_image;
        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $validated['banner_image'] = $file->storeAs('event-photos', $fileName, 'public');
        }

        $validated['organizer_id'] = Auth::id();
        $event->update($validated);

        if ($request->has('artists')) {
            $syncData = [];
            foreach ($request->artists as $artist) {
                $syncData[$artist['id']] = [
                    'event_role' => $artist['event_role'] ?? null,
                ];
            }
            $event->artists()->sync($syncData);
        }

        return redirect()->route('admin.events.index')->with('message', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('admin.events.index')->with('message', 'Event deleted successfully.');
    }
}
