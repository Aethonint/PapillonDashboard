<?php

namespace App\Http\Controllers\Admin;
use App\Models\Categorie;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
public function index()
    {
        $categories = Categorie::with('parent', 'children')->get()->whereNull('parent_id');
       return view('admin.category.index', compact('categories'));
       
    }
    public function create()
    {
        $categories = Categorie::with('parent', 'children')->get()->whereNull('parent_id');
        return view('admin.category.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $count = 2;

        while (Categorie::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        Categorie::create([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('category.index')->with('success', 'Categorie added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
   

    /**
     * Update the specified resource in storage.
     */
    public function edit(Categorie $category)
{
    // Fetch all categories except the current one to prevent a category from being its own parent.
    $categories = Categorie::where('id', '!=', $category->id)->get();
    
    return view('admin.category.edit', compact('category', 'categories'));
}

public function update(Request $request, Categorie $category)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'parent_id' => 'nullable|exists:categories,id',
    ]);
    
    // Check to prevent a category from being a child of one of its own children.
    $isAncestor = Categorie::where('id', $request->parent_id)
                         ->whereIn('id', $category->children->pluck('id')->toArray())
                         ->exists();
    
    if ($isAncestor) {
        return redirect()->back()->withErrors(['parent_id' => 'A category cannot be a child of its own subcategory.']);
    }

    $category->update([
        'name' => $request->name,
        'parent_id' => $request->parent_id,
    ]);

    return redirect()->route('category.index')->with('success', 'Category updated successfully!');
} public function destroy(Categorie $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Categorie deleted successfully!');
    }
   
}
