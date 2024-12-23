<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $product = Cache::remember('top_3_products', 60, function () {
            return Product::with('productCategory')->select(
                    'products.id', 
                    'products.name', 
                    'products.price', 
                    'products.weight', 
                    'products.image', 
                    'products.description', 
                    'products.product_category_id', 
                    DB::raw('COUNT(product_transaction.product_id) as product_count')
                )
                ->join('product_transaction', 'products.id', '=', 'product_transaction.product_id')
                ->groupBy(
                    'products.id', 
                    'products.name', 
                    'products.price', 
                    'products.weight', 
                    'products.image', 
                    'products.description', 
                    'products.product_category_id'
                )
                ->orderByDesc('product_count')
                ->limit(3)
                ->get();
        });

        return view('home', [
            'title' => 'Home',
            'products' => $product
        ]);
    }

}
