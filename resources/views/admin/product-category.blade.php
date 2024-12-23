@extends('layouts.dashboard')

{{-- @dd($productCategories); --}}

@section('container')
<div class="container">
  {{-- Search --}}
  <div class="row align-items-center">
    <!-- Search Bar -->
    <div class="col-md-6 mb-3 mb-md-0">
      <form action="{{ route('searchCategory') }}" method="POST" class="input-group">
        <input 
          type="text" 
          class="form-control" 
          placeholder="Search category name..." 
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
      <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addCategory">New Category</button>
    </div>
  </div>

  @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @elseif (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif


    @isset($productCategories)
    @if($productCategories->isNotEmpty())
    <div class="row justify-content-start my-3 g-3">
      @foreach ($productCategories as $category)
      <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
          <div class="card shadow-sm h-100">
              <div class="card-body d-flex flex-column justify-content-between">
                  <div>
                      <h5 class="card-title fw-bold text-danger">{{ $category->category_name }}</h5>
                      <p class="card-text text-muted">{{ $category->description }}</p>
                  </div>
                  <div class="my-3">
                      <button class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editCategory{{ $category->id }}">
                          <i class="bi bi-pencil-square"></i> Edit
                      </button>
                      <form method="POST" action="{{ route('category.destroy', $category->id) }}" class="d-inline">
                          @method('delete')
                          @csrf
                          <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                              <i class="bi bi-x-circle"></i> Delete
                          </button>
                      </form>
                      <p class="card-text mt-3">
                          <small class="text-muted">Last updated {{ $category->updated_at->diffForHumans() }}</small>
                      </p>
                  </div>
              </div>
          </div>
      </div>
  
      <!-- Edit Modal -->
      <div class="modal fade" id="editCategory{{ $category->id }}" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title">Update Category</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                      <form method="POST" action="/admin/category/{{ $category->id }}/edit">
                          @method('PUT')
                          @csrf
                          <div class="mb-3">
                              <label for="category_name" class="form-label">Category Name</label>
                              <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="name" name="category_name" value="{{ old('category_name', $category->category_name) }}">
                              @error('category_name')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                          <div class="mb-3">
                              <label for="description" class="form-label">Category Desc</label>
                              <textarea class="form-control" id="description" name="description">{{ old('description', $category->description) }}</textarea>
                          </div>
                          <button type="submit" class="btn btn-danger">Update</button>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                  </div>
              </div>
          </div>
      </div>
      @endforeach
  </div>
  
  <!-- Add Category Modal -->
  <div class="modal fade" id="addCategory" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Add New Category</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                  <form method="POST" action="{{ route('category.store') }}">
                      @csrf
                      <div class="mb-3">
                          <label for="category_name" class="form-label">Category Name</label>
                          <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="name" name="category_name" value="{{ old('category_name') }}">
                          @error('category_name')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                      <div class="mb-3">
                          <label for="description" class="form-label">Category Description</label>
                          <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                      </div>
                      <button type="submit" class="btn btn-warning">Add</button>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
  
    @else
        <div class="alert alert-warning text-center py-5 mt-4">
            <i class="bi bi-exclamation-circle display-3 text-warning"></i>
            <h4 class="mt-3">No categories found for the search input.</h4>
        </div>
    @endif
  @endisset

</div>

{{-- Pagination --}}
{{ $productCategories->links() }}
@endsection
