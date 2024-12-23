<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Cache;

class ProductCategoryControllerView extends Controller
{
    public function index(ProductCategory $category) 
    {
        $categories = $category->with('products')->where('id', $category->id)->paginate(20);
    
        return view('product-category', [
            'title' => 'Product Category',
            'categories' => $categories,
        ]);
    }
}
