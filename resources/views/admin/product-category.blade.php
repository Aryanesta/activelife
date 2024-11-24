@extends('layouts.dashboard')

@section('container')
<div class="container">

  <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addCategory">New Category</button>

  @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="row justify-content-start my-3 gap-2">
    @foreach ($productCategories as $category)
    <div class="card mb-3 col-xl-4 col-lg-6 col-sm-6" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title" style="font-weight: bold">{{ $category->category_name }}</h5>
          <p class="card-text">{{ $category->description }}</p>
          <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCategory{{ $category->id }}"><i class="bi bi-pencil-square"></i></button>
          <form method="POST" action="/admin/product-category/{{ $category->id }}" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-x-circle"></i></button>
          </form>
          <p class="card-text mt-3"><small class="text-muted">Last updated {{ $category->updated_at->diffForHumans() }}</small></p>
        </div>
      </div>

        <!-- Edit Kategori -->
        <div class="modal fade" id="editCategory{{ $category->id }}">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                <h4 class="modal-title">Update Category</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                <form method="POST" action="/admin/product-category/{{ $category->id }}/edit">
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
                    
                    <button type="submit" class="btn btn-primary">Update</button>
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

  <!-- Tambah Kategori -->
  <div class="modal fade" id="addCategory">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Add New Item</h4>
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
              <label for="description" class="form-label">Category Desc</label>
              <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
            </div>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Add New</button>
        
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>


      </div>
    </div>
  </div>
</div>
@endsection
