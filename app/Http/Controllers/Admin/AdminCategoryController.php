<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::orderBy('id', 'desc');
        if ($request->userSearch) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->userSearch . '%');
            });
        }
        $categories = $query->paginate(10)->withQueryString();
        return Inertia::render('Admin/Category/CategoryIndex', [
            'categories' => $categories,
            'filters' => $request->only('userSearch'),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Category/CategoryCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'status' => 'nullable',
            'description' => 'nullable|string',
            'categoryPhoto' => 'nullable|file|mimes:jpeg,png|max:2048',
        ]);

        if ($request->hasFile('categoryPhoto')) {
            $file = $request->file('categoryPhoto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('category-photos', $fileName, 'public');
        }

        Category::create([
            'name' => $request->name,
            'status' => $request->status,
            'short_description' => $request->description,
            'event_logo' => $request->hasFile('categoryPhoto') ? $filePath : null,
        ]);

        return redirect()->route('admin.event-categories.index')->with('message', 'Event category created successfully.');
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
        $category = Category::findOrFail($id);
        return Inertia::render('Admin/Category/CategoryCreate', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $validated = $request->validate([
            'name'          => 'required|string',
            'status'        => 'nullable',
            'description'   => 'nullable|string',
            'categoryPhoto' => 'nullable|file|mimes:jpeg,png|max:2048',
        ]);

        $filePath = $category->event_logo;

        if ($request->hasFile('categoryPhoto')) {
            $file = $request->file('categoryPhoto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('category-photos', $fileName, 'public');
        }

        $category->update([
            'name'              => $validated['name'],
            'short_description' => $validated['description'],
            'event_logo'        => $filePath,
            'status'            => $validated['status'], // 1 = active, 0 = inactive
        ]);
        return redirect()->route('admin.event-categories.index')->with('message', 'Event category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $getCategory = Category::findOrFail($id);
        $getCategory->delete();
        return redirect()->route('admin.event-categories.index')->with('message', 'Event category deleted successfully.');
    }
}
