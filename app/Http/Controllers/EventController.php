<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
     public function show($id)
    {
        $event = Event::with('seats')->find($id);

        return Inertia::render('Customer/EventShow', [
            'event' => $event,
            'seats' => $event->seats,
        ]);
    }
}
