<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;

class AdminArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'name' => 'required|string',
            'primary_role' => 'nullable|string',
            'bio' => 'nullable|string',
            'photo' => 'nullable|file|mimes:jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('artist-photos', $fileName, 'public');
        }

        Artist::create([
            'name' => $request->name,
            'primary_role' => $request->primary_role,
            'bio' => $request->bio,
            'photo' => $request->hasFile('photo') ? $filePath : null,
        ]);

        return redirect()->route('admin.events.create')->with('message', 'Artist created successfully.');
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

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string|min:2',
        ]);

        return Artist::where('name', 'like', "%{$request->q}%")->select('id', 'name', 'primary_role')->limit(10)->get();
    }
}
