@extends('layouts.dashboard')

@section('container')
<div class="container">
  <div class="row align-items-center">
    <!-- Search Bar -->
    <div class="col-md-6 mb-3 mb-md-0">
      <form action="{{ route('searchProduct') }}" method="POST" class="input-group">
        <input 
          type="text" 
          class="form-control" 
          placeholder="Search product name..." 
          id="product-search-input"
          name="query-input"
        >
        @csrf
        <button 
          class="btn btn-danger" 
          id="product-search-btn"
        >
          Search
        </button>
      </form>
    </div>

    <!-- Add Product Button -->
    <div class="col-md-6 text-md-end text-center">
      <button 
        class="btn btn-danger" 
        data-bs-toggle="modal" 
        data-bs-target="#addProduct"
      >
        Add Product
      </button>
    </div>
  </div>


  @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @elseif(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

    @isset($products)
      @if($products->isNotEmpty())
        <div class="table-responsive mt-3">
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Description</th>
                <th>Last Updated</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="product-container">
              @foreach ($products as $index => $product)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                  @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 80px;">
                  @else
                    <img src="../upload/product-1.png" alt="{{ $product->name }}" style="max-width: 80px;">
                  @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>Rp{{ $product->price }}</td>
                <td>{{ $product->stock}}</td>
                <td>{{ Str::limit($product->description, 50, '...') }}</td>
                <td>{{ $product->updated_at->diffForHumans() }}</td>
                <td>
                  <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProduct{{ $product->id }}">
                    <i class="bi bi-pencil-square"></i>
                  </button>
                  <form method="POST" action="/admin/product/{{ $product->id }}" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                      <i class="bi bi-x-circle"></i>
                    </button>
                  </form>
                </td>
              </tr>
                  <!-- Modal Edit Product -->
                <div class="modal fade" id="editProduct{{ $product->id }}">
                  <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title">Update Item</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                              <form method="POST" action="/admin/product/{{ $product->id }}" enctype="multipart/form-data">
                                  @method('PUT')
                                  @csrf
                                  <div class="mb-3">
                                      <label for="name" class="form-label">Product Name</label>
                                      <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}">
                                      @error('name')
                                      <div class="invalid-feedback">{{ $message }}</div>
                                      @enderror
                                  </div>
                                  <div class="mb-3">
                                      <label for="price" class="form-label">Price</label>
                                      <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" inputmode="numeric" value="{{ old('price', $product->price) }}">
                                      @error('price')
                                      <div class="invalid-feedback">{{ $message }}</div>
                                      @enderror
                                  </div>
                                  <div class="mb-3">
                                      <label for="weight" class="form-label">Weight (Gram)</label>
                                      <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" inputmode="numeric" value="{{ old('weight', $product->weight) }}">
                                      @error('weight')
                                      <div class="invalid-feedback">{{ $message }}</div>
                                      @enderror
                                  </div>
                                  <div class="mb-3">
                                      <label for="stock" class="form-label">Stock</label>
                                      <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" inputmode="numeric" value="{{ old('stock', $product->stock) }}">
                                      @error('stock')
                                      <div class="invalid-feedback">{{ $message }}</div>
                                      @enderror
                                  </div>
                                  <div class="mb-3">
                                      <input type="hidden" name="oldImage" value="{{ $product->image }}">
      
                                      <label for="image" class="form-label">Product Image</label>
                                      <img class="img-preview img-fluid" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                      <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" onchange="previewImage()">
                                      @error('image')
                                      <div class="invalid-feedback">{{ $message }}</div>
                                      @enderror
                                  </div>
                                  <div class="mb-3">
                                      <label for="description" class="form-label">Product Desc</label>
                                      <textarea class="form-control" id="description" name="description">{{ old('description', $product->description) }}</textarea>
                                  </div>
                                  <div class="mb-3">
                                      <label for="category" class="form-label">Product Category</label>
                                      <select name="product_category_id" id="category" class="form-select">
                                          @foreach ($categories as $category)
                                          <option value="{{ $category->id }}" 
                                              {{ old('product_category_id', $product->product_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                              {{ $category->category_name }}
                                          </option>
                                          @endforeach
                                      </select>
                                  </div>   
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning">Update</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
              @endforeach
            </tbody>
          </table>
        </div>
      
      </div>
        <!-- Tambah PRODUKK -->
        <div class="modal fade" id="addProduct">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
      
              <div class="modal-header">
                <h4 class="modal-title">Add New Item</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
      
              <div class="modal-body">
                <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                    @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" inputmode="numeric" value="{{ old('price') }}">
                    @error('price')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3">
                      <label for="weight" class="form-label">Weight (Gram)</label>
                      <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" inputmode="numeric" value="{{ old('weight') }}">
                      @error('weight')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="mb-3">
                      <label for="stock" class="form-label">Stock</label>
                      <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" inputmode="numeric" value="{{ old('stock') }}">
                      @error('stock')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
                  <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label for="description" class="form-label">Product Desc</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                  </div>
                  <div class="mb-3">
                    <label for="category">Product Category</label>
                    <select class="form-control" id="category" name="product_category_id">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>          
                <div class="modal-footer">
                  <button type="submit" class="btn btn-warning">Submit</button>
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      @else
          <div class="alert alert-warning text-center py-5 mt-4">
              <i class="bi bi-exclamation-circle display-3 text-warning"></i>
              <h4 class="mt-3">No products found for the search input.</h4>
          </div>
      @endif
  @endisset

{{-- Pagination --}}
{{ $products->links() }}

<script>
function previewImage() {
    const input = document.querySelector('#image');
    const imagePreview = document.querySelector('.img-preview');

    const oFReader = new FileReader();
    oFReader.readAsDataURL(input.files[0]);

    oFReader.onload = function(oFEvent) {
        imagePreview.src = oFEvent.target.result;
    }
}
</script>
@endsection


