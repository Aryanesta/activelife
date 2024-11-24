<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Routing\Controller;

class ProductControllerView extends Controller
{
    public function index() {
        return view('product', [
            'title' => 'Product',
            'products' => Product::all(),
            'categories' => ProductCategory::all()
        ]);
    }
}
