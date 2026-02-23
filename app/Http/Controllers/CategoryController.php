<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('name', $slug)
            ->with(['events' => function ($query) {
                $query->where('status', 'published')->latest()->paginate(9);
            }])
            ->firstOrFail();

        return Inertia::render('Customer/CategoryShow', [
            'category' => $category,
            'events' => $category->events()->latest()->paginate(9),
        ]);
    }
}
