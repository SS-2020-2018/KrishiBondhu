<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_available', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }

        $products = $query->orderBy('created_at', 'desc')->get();

        return view('marketplace.index', compact('products'));
    }

    public function create()
    {
        if (!in_array(Auth::user()->role, ['farmer', 'seller'])) {
            return redirect()->route('marketplace.index')->with('error', 'Unauthorized! Only Farmers or Sellers can create item listings.');
        }

        return view('marketplace.create');
    }

    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['farmer', 'seller'])) {
            return redirect()->route('marketplace.index')->with('error', 'Unauthorized operation.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'listing_type' => 'required|in:sell,rent',
            'location' => 'required|string|max:255',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        Category::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'General Agricultural Machinery',
                'slug' => 'general-machinery',
                'type' => 'equipment'
            ]
        );

        $imagePath = null;
        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('products', 'public');
        }

        Product::create([
            'user_id' => Auth::id(),
            'category_id' => 1, // Will now safely find the row we verified above!
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'description' => $request->description,
            'listing_type' => $request->listing_type,
            'location' => $request->location,
            'is_available' => true,
        ]);

        return redirect()->route('marketplace.index')->with('success', 'Equipment listed on the marketplace successfully!');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('marketplace.show', compact('product'));
    }

    public function myListings()
    {
        $products = Product::where('user_id', Auth::id())->get();
        return view('marketplace.my_listings', compact('products'));
    }
}