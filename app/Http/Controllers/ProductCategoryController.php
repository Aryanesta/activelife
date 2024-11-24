<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('/admin/product-category', [
            'title' => 'Product Category',
            'productCategories' => ProductCategory::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'category_name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        ProductCategory::create($validateData);
        
        return redirect(route('category.index'))->with('success', 'New Category added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $validateData = $request->validate([
            'category_name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        ProductCategory::where('id',  $productCategory->id)->update($validateData);
        
        return redirect(route('category.index'))->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        ProductCategory::destroy($productCategory->id);
        
        return redirect(route('category.index'))->with('success', 'Category deleted successfully!');
    }
}
