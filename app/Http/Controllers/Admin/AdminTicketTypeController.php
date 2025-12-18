<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TicketTypeStoreRequest;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminTicketTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function eventIndex(Event $event, Request $request)
    {
        $query = $event->ticketTypes()->orderBy('sort_order', 'asc');

        if ($request->categorySearch) {
            $query->where('name', 'like', '%' . $request->categorySearch . '%');
        }

        return Inertia::render('Admin/TicketType/TicketTypeIndex', [
            'event' => $event,
            'ticketTypes' => $query->paginate(10)->withQueryString(),
            'filters' => $request->only('categorySearch'),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        return Inertia::render('Admin/TicketType/TicketTypeCreate', [
            'event' => $event,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketTypeStoreRequest $request)
    {
        // dd($request->validated());
        TicketType::create($request->validated());
        return redirect()->route('admin.events.ticket-types.index', ['event' => $request->event_id])->with('success', 'Ticket type created successfully');
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
    public function edit(TicketType $ticket)
    {
        return Inertia::render('Admin/TicketType/TicketTypeCreate', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
