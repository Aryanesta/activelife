<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::id();
    
        return view('cart', [
            'title' => 'Cart',
            'cart_products' => Cart::with('cartItems')->where('user_id', $user)->get(),
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
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:1',
        ]);
    
        // Mendapatkan atau membuat keranjang untuk user yang sedang login
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'active'],
            ['user_id' => Auth::id()]
        );

        $existingCartItem = CartItem::where('cart_id', $cart->id)
                                    ->where('product_id', $validatedData['product_id'])
                                    ->first();
    
        if ($existingCartItem) {
            return response()->json(['message' => 'Produk sudah ada di keranjang']);
        }
    
        // Tambahkan item ke dalam keranjang jika belum ada
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $validatedData['product_id'],
            'quantity' => $validatedData['quantity'],
            'price' => $validatedData['price'] * $validatedData['quantity'],
            'weight' => $validatedData['weight'] * $validatedData['quantity'],
        ]);
    
        // Update status product (contoh tambahan logika)
        $product = Product::find($validatedData['product_id']);
        if ($product) {
            // $product->is_in_cart = true;
            $product->save();
        }
    
        // Hitung total item di dalam keranjang
        $updatedCartQuantity = $cart->cartItems->count();
    
        return response()->json([
            'updatedCartQuantity' => $updatedCartQuantity,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
        ]);
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartItem $item)
    {
        $cartItem = CartItem::find($request->item_id);

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;

            if ($request->quantity != 1) {
                $cartItem->price = $cartItem->product->price * $request->quantity;
                $cartItem->weight = $cartItem->product->weight * $request->quantity;
            } else {
                $cartItem->price = $cartItem->product->price;
                $cartItem->weight = $cartItem->product->weight;
            }

            $cartItem->save();
    
            return response()->json([
                'newQuantity' => $cartItem->quantity,
                'newPrice' => $cartItem->price,
                'newWeight' => $cartItem->weight,
            ]);
        }
    
        return response()->json(['error' => 'Item not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $product = $cartItem->product;

        if ($cartItem) {
            if ($product) {
                // $product->is_in_cart = false;
                $product->save();
            }
    
            $cartItem->delete();
    
            $updatedCartQuantity = Cart::with('cartItems')
                ->where('user_id', Auth::id())
                ->get()
                ->sum(fn($cart) => $cart->cartItems->count());
    
            return response()->json(['updatedCartQuantity' => $updatedCartQuantity]);
        }
    
        return response()->json(['error' => 'Item tidak ditemukan.'], 404);

        // CartItem::destroy($cartItem->id);
        
        // return redirect(route('cart.index'))->with('delete-success', 'Item berhasil dihapus dari keranjang!');
    }
}
