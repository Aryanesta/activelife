@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-column align-items-center my-5">
        <h1>{{ __('Reset Password') }}</h1>

        <!-- Alert untuk status reset password -->
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form untuk reset password -->
        <form method="POST" action="{{ route('password.email') }}" class="border auth">
            @csrf

            <!-- Input untuk email -->
            <div class="mb-3">
                <label for="email" class="mb-2">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                
                <!-- Error handling untuk email -->
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Tombol untuk mengirim link reset password -->
            <button type="submit" class="btn btn-danger">
                {{ __('Send Password Reset Link') }}
            </button>
        </form>
    </div>
</div>

@endsection
