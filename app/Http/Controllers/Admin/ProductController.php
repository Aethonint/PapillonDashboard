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
    $products = Product::with(['category', 'subcategory'])->latest()->get();
    return view('admin.product.index',compact('products'));

   }
   public function create()
   {
     $categories = Categorie::with('parent', 'children')->get()->whereNull('parent_id');
    return view('admin.product.create',compact('categories'));
   }
   public function show($id)
{
    $product = Product::with(['category', 'subcategory'])->findOrFail($id);
    return view('admin.product.show', compact('product'));
}

public function store(Request $request)
{
    // Validate
   $validated = $request->validate([
    'name' => 'required|string|max:255',
    'price' => 'required|numeric|min:0',
      'subcategory_id' => 'nullable|exists:categories,id',
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
          $product->price = $validated['price'];
          $product->subcategory_id = $validated['subcategory_id'] ?? null;
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


 public function edit($id)
{
    $product = Product::findOrFail($id);

    // Fetch all categories (both parent and child)
    $categories = Categorie::all();

    return view('admin.product.edit', compact('product', 'categories'));
}

// public function update(Request $request, $id)
// {
//     $product = Product::findOrFail($id);

//     $request->validate([
//         'name' => 'required|string|max:255',
//         'category_id' => 'required|exists:categories,id',
//         'subcategory_id' => 'nullable|exists:categories,id',
//         'type' => 'required|in:text_only,image_only,text_image,fixed',
//         'price' => 'required|numeric|min:0',
//         'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
//         'background_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
//     ]);

//     $product->name = $request->name;
//     $product->category_id = $request->category_id;
//     $product->subcategory_id = $request->subcategory_id;
//     $product->type = $request->type;
//     $product->price = $request->price;
//     $product->status = $request->status ?? 1;

//     if ($request->hasFile('thumbnail')) {
//         $product->thumbnail = $request->file('thumbnail')->store('products/thumbnails', 'public');
//     }

//     if ($request->hasFile('background_image')) {
//         $product->background_image = $request->file('background_image')->store('products/backgrounds', 'public');
//     }

//     $product->text_zones = $request->text_zones;
//     $product->image_zones = $request->image_zones;

//     $product->save();

//     return redirect()->route('product.index')->with('success', 'Product updated successfully.');
// }
public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // Validate inputs
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|integer|exists:categories,id',
        'subcategory_id' => 'nullable|integer|exists:categories,id',
        'type' => 'required|string|in:text_only,image_only,text_image,fixed',
        'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'background_image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        'text_zones' => 'nullable|string',  // JSON
        'image_zones' => 'nullable|string', // JSON
    ]);

    // Update basic fields
    $product->name = $request->name;
    $product->price = $request->price;
    $product->category_id = $request->category_id;
    $product->subcategory_id = $request->subcategory_id;
    $product->type = $request->type;

    // Handle Thumbnail
    if ($request->hasFile('thumbnail')) {
        // Delete old if exists
        if ($product->thumbnail && \Storage::exists('public/'.$product->thumbnail)) {
            \Storage::delete('public/'.$product->thumbnail);
        }
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        $product->thumbnail = $thumbnailPath;
    }

    // Handle Background Image
    if ($request->hasFile('background_image')) {
        if ($product->background_image && \Storage::exists('public/'.$product->background_image)) {
            \Storage::delete('public/'.$product->background_image);
        }
        $bgPath = $request->file('background_image')->store('backgrounds', 'public');
        $product->background_image = $bgPath;
    }

    // Handle Zones
    $product->text_zones = $request->filled('text_zones') ? $request->text_zones : '[]';
    $product->image_zones = $request->filled('image_zones') ? $request->image_zones : '[]';

    $product->save();

    return redirect()->route('product.index')->with('success', 'Product updated successfully!');
}


public function destroy($id)
{
    $product = Product::findOrFail($id);

    // Delete image file if exists
    if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
        unlink(public_path('uploads/products/' . $product->image));
    }

   

    // Delete product
    $product->delete();

    return redirect()->route('product.index')->with('success', 'Product and its zones deleted successfully.');
}




   public function edit_user($id)
   {
$product = Product::findOrFail($id);

    // Fetch all categories (both parent and child)
    $categories = Categorie::all();

    return view('admin.product.edituser', compact('product', 'categories'));
   }
}
