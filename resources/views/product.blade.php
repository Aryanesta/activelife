@extends('layouts.main')

@section('container')

<div class="container-sm">
    <div class="row row-cols-3 row-cols-md-4 row-cols-lg-6" id="products">
        @foreach ($products as $product)      
            <div class="card col-lg-3 col-6 mb-3 border-0 product-card">
                <div class="card-body">
                    @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top mb-2">
                @else
                    <img src="../upload/product-1.png" class="card-img-top mb-2" alt="{{ $product->name }}">
                @endif
                    <h5 class="card-title" style="font-weight: bolder">{{ $product->name }}</h5>
                    <h6 class="card-text text-success">Price: Rp. {{ number_format($product->price, 2) }}</h6>
                    <p class="card-text">{{ $product->description }}</p>
            
                    @auth
                    <div class="d-flex justify-content-center gap-2">
                        <div class="cart-button">
                            <button class="btn btn-warning addCartButton" data-product-id="{{ $product->id }}" data-price="{{ $product->price }}" data-weight="{{ $product->weight }}">
                                <i class="bi bi-cart4"></i><span class="btn-text"> Add to Cart</span>
                            {{-- @if (!$product->is_in_cart)
                            @else
                                <button class="btn btn-warning">
                                    <i class="bi bi-check2"></i><span class="btn-text">In Cart</span>
                                </button>
                            @endif --}}
                        </div>
                            <button class="btn btn-danger"><i class="bi bi-eye"></i></button>
                        </div>
                    @endauth
                </div>
            </div>
      @endforeach
    </div>
</div>

<script>

$(document).ready(function() {
    $('.addCartButton').on('click', function(e) {
        e.preventDefault();

        // Get data attributes
        let productId = $(this).data('product-id');
        let price = $(this).data('price');
        let weight = $(this).data('weight');
        let quantity = 1; // Default quantity, can be changed

        let button = $(this);

        // Send AJAX request
        $.ajax({
            url: '{{ route("cart.store") }}', // Route to handle the AJAX request
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // CSRF token for security
                product_id: productId,
                price: price,
                weight: weight,
                quantity: quantity
            },
            success: function(response) {
                toastr.success(response.message);

                // let cartButton = `<button class="btn btn-warning">
                //                         <i class="bi bi-check2"></i> In Cart
                //                     </button>`; 
                // button.closest('.cart-button').html(cartButton);

                $('#cart-quantity').html(response.updatedCartQuantity);

            },
            error: function(xhr) {
                toastr.error("Product failed added to cart!");
                console.log(xhr.responseText);
            }
        });
    });
});
</script>

@endsection