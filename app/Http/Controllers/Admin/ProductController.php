<?php

namespace App\Http\Controllers\Admin;
use App\Models\Categorie;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function index()
   {
    return view('admin.product.index');

   }
   public function create()
   {
     $categories = Categorie::with('parent', 'children')->get()->whereNull('parent_id');
    return view('admin.product.create',compact('categories'));
   }
   public function show()
   {
    
   }
public function store(Request $request)
{
    // Validate
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'type' => 'required|in:text_only,image_only,text_image,fixed',
        'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'background_image' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        'text_zones' => 'nullable|json',
        'image_zones' => 'nullable|json',
    ]);

    try {
        // debug: quickly check if file is present (uncomment while debugging)
        // dd($request->hasFile('background_image'), array_keys($request->files->all()));

        // Handle thumbnail
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('products/thumbnails', 'public');
        }

        // Handle background image (required per validation)
        $backgroundPath = null;
        if ($request->hasFile('background_image')) {
            $backgroundPath = $request->file('background_image')->store('products/backgrounds', 'public');
        } else {
            // Should not happen because validation requires it, but keep safe fallback
            return back()->withErrors(['background_image' => 'Background image was not uploaded. Please try again.']);
        }

        $product = new \App\Models\Product();
        $product->name = $validated['name'];
        $product->category_id = $validated['category_id'];
        $product->type = $validated['type'];
        $product->thumbnail = $thumbnailPath;
        $product->background_image = $backgroundPath;
        $product->text_zones = $validated['text_zones'] ?? null;
        $product->image_zones = $validated['image_zones'] ?? null;
        $product->status = true;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product created successfully!');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
    }
}


   public function edit()
   {
    
   }
   public function destroy()
   {
    
   }
}
