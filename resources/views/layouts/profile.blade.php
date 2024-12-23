@extends('layouts.main')

@section('container')
<div class="container mt-5">
    <div class="row g-4 justify-content-center">
        <!-- Navigasi Profil -->
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="card shadow-sm p-3" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="upper-body d-flex flex-column align-items-center mb-4">
                        <img src="{{ asset(auth()->user()->image ? 'storage/' . auth()->user()->image : 'storage/user-profile/placeholder.png') }}" 
                             alt="Profile Image" width="120px" height="120px" class="rounded-circle shadow-sm mb-3">
                        <h5 class="text-center mt-3 fw-bold">{{ auth()->user()->name }}</h5>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                    </div>
                    <div class="profile-nav d-flex flex-column gap-2">
                        <a href="{{ route('profile') }}" class="btn {{ request()->is('profile') ? 'btn-danger' : 'btn-outline-dark' }} d-flex align-items-center gap-2 py-2 px-3 rounded-pill">
                            <i class="bi bi-person-fill"></i> User Profile
                        </a>
                        <a href="{{ route('transaction-history') }}" class="btn {{ request()->is('transaction-history') ? 'btn-danger' : 'btn-outline-dark' }} d-flex align-items-center gap-2 py-2 px-3 rounded-pill">
                            <i class="bi bi-clock-history"></i> Transaction History
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline btn btn-outline-dark rounded-pill py-2 px-3">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center" style="font-weight: 500; gap: 20px"><i class="bi bi-box-arrow-left"></i> Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Navigasi -->
        <div class="col-lg-8 col-md-8 col-sm-12">
            <div class="card shadow-sm" style="border-radius: 15px;">
                @yield('nav-detail')
            </div>
        </div>
    </div>
</div>
@endsection