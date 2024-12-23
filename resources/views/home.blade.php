@extends('layouts.main')

{{-- @dd($products) --}}

@section('container')
<div class="container">
    <!-- Carousel -->
    <div id="demo" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicators/dots -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
        </div>

        <!-- The slideshow/carousel -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://johnsonfitness.id/wp-content/uploads/2024/10/10.10-WEB.png" alt="Slide 1" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="https://johnsonfitness.id/wp-content/uploads/2024/10/10.10-WEB.png" alt="Slide 2" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="https://johnsonfitness.id/wp-content/uploads/2024/10/10.10-WEB.png" alt="Slide 3" class="d-block w-100">
            </div>
        </div>

        <!-- Left and right controls/icons -->
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Section 1: Strong. Smart. Beautiful -->
    <section class="section py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Kolom Kiri -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="https://johnsonfitness.id/wp-content/uploads/2022/04/matrix-fix.png" alt="Matrix Logo" width="200" height="75" class="img-fluid">
                    <h2 class="mt-3">Strong. Smart. Beautiful</h2>
                    <p>It’s more than a tagline. It’s our holistic promise to you that these three qualities will shine through every product that hits your floor and define our ongoing partnership.</p>
                </div>
                <!-- Kolom Kanan -->
                <div class="col-lg-6">
                    <img src="https://johnsonfitness.id/wp-content/uploads/2022/03/2.jpg" alt="Matrix Product" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Vision Fitness -->
    <section class="section py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="https://johnsonfitness.id/wp-content/uploads/2022/03/1.jpg" alt="Vision Fitness" class="img-fluid rounded">
                </div>
                <div class="col-md-6 text-center">
                    <img src="https://johnsonfitness.id/wp-content/uploads/2022/03/black-vision-logo.png" alt="Vision Logo" style="width: 200px;" class="mb-3">
                    <h2>It all starts with a Vision</h2>
                    <p>Vision Fitness prides itself on creating high-quality fitness products at an exceptional value.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3: Matrix Logo and Product -->
    <section class="section py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Kolom Kiri -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="https://johnsonfitness.id/wp-content/uploads/2022/04/matrix-fix.png" alt="Matrix Logo" width="200" height="75" class="img-fluid">
                    <h2 class="mt-3">Strong. Smart. Beautiful</h2>
                    <p>It’s more than a tagline. It’s our holistic promise to you that these three qualities will shine through every product that hits your floor and define our ongoing partnership.</p>
                </div>
                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <img loading="lazy" decoding="async" src="https://johnsonfitness.id/wp-content/uploads/2022/03/3.jpg" alt="Fitness Equipment" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Best Seller Products -->
    <section class="section-best-seller py-5 bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">Best Seller Products</h2>
                <p class="text-muted">Explore our most popular fitness equipment loved by customers.</p>
            </div>
            <div class="row">
                @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card product-card h-100 shadow-sm py-4 border-0">
                        <div class="card-img-top position-relative">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200' }}" alt="{{ $product->name }}" class="img-fluid rounded-top">
                            @if ($product->created_at >= now()->subMonth())
                                <span class="badge bg-success position-absolute top-0 end-0 m-2">New</span>
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                            <h6 class="card-text text-success">Rp{{ number_format($product->price, 2) }}</h6>
                            <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit($product->description, 50) }}</p>
                        </div>
                        @auth
                        <div class="card-footer bg-white border-0 d-flex justify-content-around">
                            <button class="btn btn-warning addCartButton" data-product-id="{{ $product->id }}" data-price="{{ $product->price }}" data-weight="{{ $product->weight }}">
                                <i class="bi bi-cart4"></i> Add to Cart
                            </button>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                                <i class="bi bi-eye"></i> <span class="product-button">View</span>
                            </button>
                        </div>
                        @endauth
                    </div>
                </div>
                  <!-- The Modal -->
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
    </section>
</div>
  
<script>
    $(document).ready(function() {
    $('.addCartButton').on('click', function(e) {
        e.preventDefault();

        let productId = $(this).data('product-id');
        let price = $(this).data('price');
        let weight = $(this).data('weight');
        let quantity = 1;

        let button = $(this);

        $.ajax({
            url: '{{ route("cart.store") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                price: price,
                weight: weight,
                quantity: quantity
            },
            success: function(response) {
                toastr.success(response.message);

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