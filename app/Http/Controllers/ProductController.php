<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_on_sale', true);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $products = $query->orderBy('created_at', 'desc')->get();

        $categories = Product::where('is_on_sale', true)
                             ->distinct()
                             ->pluck('category');

        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        if (!$product->is_on_sale) {
            return redirect()->route('products.index')->with('error', 'Bu ürün şu an satışta değildir.');
        }

        $relatedProducts = Product::where('category', $product->category)
                                  ->where('id', '!=', $product->id)
                                  ->where('is_on_sale', true)
                                  ->take(4)
                                  ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function landing()
    {
        $featuredProducts = Product::where('is_on_sale', true)
                                   ->orderBy('created_at', 'desc')
                                   ->take(3)
                                   ->get();

        return view('landing', compact('featuredProducts'));
    }
}
