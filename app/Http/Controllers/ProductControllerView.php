<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

class ProductControllerView extends Controller
{
    public function index()
    {
        return view('product', [
            'title' => 'Product',
            'products' => Product::paginate(20),
            'categories' => ProductCategory::all(),
        ]);
    }
    

    public function getProductByName(Request $request) {
        $query = $request->input('query-input');
        
        $products = Product::where('name', 'like', '%'.$query.'%')->paginate(20);

        return view('/product', [
            'title' => 'Product',
            'products' => $products,
            'queryInput' => $query,
            'categories' => ProductCategory::all()
        ]);
    }
}
