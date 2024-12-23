<header class="navbar navbar-dark sticky-top bg-danger flex-md-nowrap py-2 shadow" style="position: fixed; width: 100vw">
    <div class="container-fluid">
        <!-- Logo dan Nama Website -->
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ route('home') }}">ActiveLife</a>
        
        <!-- Toggler Button untuk layar kecil -->
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Form Search (Dihapuskan pada permintaan sebelumnya) -->

        <!-- Back to Store Link -->
        <div class="navbar-nav ms-auto">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="{{ route('home') }}" id="back-to-store">Back to Store</a>
            </div>
        </div>
    </div>
</header>
