@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-column align-items-center my-5">
        <h1>Sign Up</h1>
        <form action="{{ route('register') }}" method="POST" class="border auth">
            @csrf
            
            <!-- Input untuk Nama -->
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Name:</label>
                <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    placeholder="Name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                />
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input untuk Username -->
            <div class="mb-3 mt-3">
                <label for="username" class="form-label">Username:</label>
                <input
                    type="text"
                    class="form-control @error('username') is-invalid @enderror"
                    id="username"
                    placeholder="Username"
                    name="username"
                    value="{{ old('username') }}"
                    required
                />
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input untuk Email -->
            <div class="mb-3 mt-3">
                <label for="email" class="form-label">Email:</label>
                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    placeholder="example@mail.com"
                    name="email"
                    value="{{ old('email') }}"
                    required
                />
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input untuk Password -->
            <div class="mb-3 mt-3">
                <label for="password" class="form-label">Password:</label>
                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password"
                    placeholder="Password"
                    name="password"
                    required
                />
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input untuk Password Confirmation -->
            <div class="mb-3 mt-3">
                <label for="password_confirmation" class="form-label">Password Confirmation:</label>
                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password_confirmation"
                    placeholder="Password Confirmation"
                    name="password_confirmation"
                    required
                />
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <p>Have an Account? <a href="{{ 'login' }}">Sign In!</a></p>

            <!-- Tombol Submit -->
            <button type="submit" class="btn submit-btn btn-danger">
                Submit
            </button>
        </form>
    </div>
</div>

@endsection
