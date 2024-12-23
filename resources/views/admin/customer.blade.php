@extends('layouts.dashboard')

@section('container')
<div class="container">

    <div class="row align-items-center mb-4">
        <!-- Search Bar -->
        <div class="col-md-6 mb-3 mb-md-0">
          <form action="{{ route('searchCustomer') }}" method="POST" class="input-group">
            <input 
              type="text" 
              class="form-control" 
              placeholder="Search customer name..." 
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
      </div>
    
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @isset($customers)
        @if($customers->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $customer->image ? asset('storage/' . $customer->image) : asset('storage/user-profile/placeholder.png') }}" 
                                alt="Profile Image" id="previewImage" style="width: 50px; height:50px; border-radius: 50%;">       
                            </td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->username }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone ?? '-' }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCustomer{{ $customer->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                        </tr>
        
                        <!-- Modal Edit Customer -->
                        <div class="modal fade" id="editCustomer{{ $customer->id }}" tabindex="-1" aria-labelledby="editCustomerLabel{{ $customer->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCustomerLabel{{ $customer->id }}">Edit Customer</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('customer.update', $customer->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="name{{ $customer->id }}" class="form-label">Name</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name{{ $customer->id }}" name="name" value="{{ old('name', $customer->name) }}">
                                                @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="username{{ $customer->id }}" class="form-label">Username</label>
                                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username{{ $customer->id }}" name="username" value="{{ old('username', $customer->username) }}">
                                                @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="email{{ $customer->id }}" class="form-label">Email</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email{{ $customer->id }}" name="email" value="{{ old('email', $customer->email) }}">
                                                @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="phone{{ $customer->id }}" class="form-label">Phone</label>
                                                <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone{{ $customer->id }}" name="phone" value="{{ old('phone', $customer->phone) }}">
                                                @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <input type="hidden" name="oldImage" value="{{ $customer->image }}">
                                                <label for="image{{ $customer->id }}" class="form-label">Profile Image</label>
                                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image{{ $customer->id }}" name="image">
                                                @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Save Changes</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
        @else
            <div class="alert alert-warning text-center py-5 my-4">
                <i class="bi bi-exclamation-circle display-3 text-warning"></i>
                <h4 class="mt-3">No customers found for the search input.</h4>
            </div>
        @endif
    @endisset
</div>


{{-- Pagination --}}
{{ $customers->links() }}
@endsection
