@extends('layouts.main')

{{-- @dd($categories) --}}

@section('container')

<h1 class="d-flex justify-content-center my-5">Product Category : <b class="text-danger mx-2">{{ $categories[0]->category_name }}</b></h1>

@if(!empty($categories) && isset($categories[0]->products) && $categories[0]->products->isNotEmpty())
    <div class="container py-4">
        <div class="row g-4" id="products">
            @foreach ($categories[0]->products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card product-card h-100 shadow-sm py-3 border-0">
                        <!-- Gambar Produk -->
                        <div class="card-img-top position-relative">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('upload/product-1.png') }}" 
                                alt="{{ $product->name }}" 
                                class="img-fluid rounded-top">
                            @if ($product->created_at >= now()->subMonth())
                                <span class="badge bg-success position-absolute top-0 end-0 m-2">New</span>
                            @endif
                        </div>

                        <!-- Informasi Produk -->
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                            <h6 class="card-text text-success">Rp{{ number_format($product->price, 2) }}</h6>
                            <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit($product->description, 50) }}</p>
                        </div>

                        <!-- Tombol Aksi -->
                        @auth
                        <div class="card-footer bg-white border-0 d-flex justify-content-around">
                            <button class="btn btn-warning addCartButton" 
                                    data-product-id="{{ $product->id }}" 
                                    data-price="{{ $product->price }}" 
                                    data-weight="{{ $product->weight }}">
                                <i class="bi bi-cart4"></i> <span class="product-button">Add to Cart</span>
                            </button>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                                <i class="bi bi-eye"></i> <span class="product-button">View</span>
                            </button>                            
                        </div>
                        @endauth
                    </div>
                </div>
                    <!-- Detail -->
                    <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                    
                            <!-- Modal Header -->
                            <div class="modal-header">
                            <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                    
                            <!-- Modal Body -->
                            <div class="modal-body">
                            <div class="row">
                                <!-- Product Image -->
                                <div class="col-md-6">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200' }}" alt="{{ $product->name }}" class="img-fluid rounded">
                                </div>
                    
                                <!-- Product Info -->
                                <div class="col-md-6">
                                <h3 class="fw-bold">{{ $product->name }}</h3>
                                <h5 class="text-success">Rp{{ number_format($product->price) }}</h5>
                                <p class="text-muted small">{{ $product->description }}</p>
                                <ul class="list-unstyled">
                                    <li><strong>Weight:</strong> {{ $product->weight }}</li>
                                    <li><strong>Stock:</strong> {{ $product->stock }}</li>
                                    <li><strong>Category:</strong> {{ $product->productCategory->category_name }}</li>
                                </ul>
                                </div>
                            </div>
                            </div>
                    
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                            <button type="button" class="btn btn-warning">
                                <i class="bi bi-cart4"></i> Add to Cart
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                    
                        </div>
                        </div>
                    </div>
            @endforeach
        </div>
    </div>
@else
    <div class="container alert alert-warning text-center py-5 my-4">
        <i class="bi bi-exclamation-circle display-3 text-warning"></i>
        <h4 class="mt-3">No products found in the category.</h4>
    </div>
@endif


{{-- Pagination --}}
{{ $categories->links() }}

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