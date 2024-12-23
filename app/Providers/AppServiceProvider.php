<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\ProductCategory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $cartQuantity = Cart::with('cartItems')
                    ->where('user_id', Auth::id())
                    ->get()
                    ->sum(fn($cart) => $cart->cartItems->count());
    
                $view->with('cartQuantity', $cartQuantity);
            } else {
                $view->with('cartQuantity', 0);
            }
        });

        View::composer('partials.nav', function($view) {
            $category = ProductCategory::all();
            $view->with('categories', $category);
        });

        Paginator::useBootstrapFive();
    }
}
