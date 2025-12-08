<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $query = User::with('roles');

        // if ($request->userSearch) {
        //     $query->where(function ($q) use ($request) {
        //         $q->where('name', 'like', '%' . $request->userSearch . '%')
        //             ->orWhere('email', 'like', '%' . $request->userSearch . '%')
        //             ->orWhere('contact_number', 'like', '%' . $request->userSearch . '%');
        //     });
        // }

        // $users = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        return Inertia::render('Admin/Event/EventIndex', [
            // 'users' => $users,
            // 'filters' => $request->only('userSearch'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
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
