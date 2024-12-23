@extends('layouts.profile')

@section('nav-detail')

<div class="card-body p-4">
    <h4 class="fw-bold mb-4">User Profile</h4>
    <form enctype="multipart/form-data" method="POST" action="{{ route('updateProfile', auth()->user()) }}">
        @csrf
        @method('PUT')
    
        <!-- Upload Foto -->
        <div class="mb-4 text-center d-flex flex-column align-items-center">
            <img src="{{ asset(auth()->user()->image ? 'storage/' . auth()->user()->image : 'storage/user-profile/placeholder.png') }}" 
                 alt="Profile Image" id="previewImage" width="120px" height="120px" class="rounded-circle shadow-sm mb-3">
            
            <label for="image" class="btn btn-danger px-4 py-2 rounded-pill">
                <i class="bi bi-upload"></i> Upload New Picture
            </label>
            <input type="file" id="image" name="image" class="d-none" accept="image/*" onchange="previewFile()">
    
            <!-- Pesan Error -->
            @error('image')
            <div class="text-danger mt-2"><small>{{ $message }}</small></div>
            @enderror
        </div>
    
        <!-- Nama -->
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" placeholder="Enter your name">
            @error('name')
            <div class="text-danger mt-2"><small>{{ $message }}</small></div>
            @enderror
        </div>
    
        <!-- Username -->
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="{{ old('username', auth()->user()->username) }}" placeholder="Enter your username">
            @error('username')
            <div class="text-danger mt-2"><small>{{ $message }}</small></div>
            @enderror
        </div>
    
        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" class="form-control bg-white" value="{{ auth()->user()->email }}" readonly>
        </div>
    
        <!-- Phone -->
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="number" id="phone" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone) }}" placeholder="Enter your phone number">
            @error('phone')
            <div class="text-danger mt-2"><small>{{ $message }}</small></div>
            @enderror
        </div>
    
        <!-- Address -->
        <div class="mb-4">
            <label for="address" class="form-label">Address</label>
            <textarea id="address" name="address" class="form-control" rows="3" placeholder="Enter your address">{{ old('address', auth()->user()->address) }}</textarea>
            @error('address')
            <div class="text-danger mt-2"><small>{{ $message }}</small></div>
            @enderror
        </div>
    
        <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill">Save Changes</button>
    </form>
    
</div>

<script>
    function previewFile() {
        const input = document.getElementById('image');
        const preview = document.getElementById('previewImage');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection