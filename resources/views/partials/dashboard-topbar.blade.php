<header class="navbar navbar-dark sticky-top bg-danger flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 bg-danger" href="{{ route('home') }}">ActiveLife</a>
  
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Form Search -->
  <form class="w-100 m-0" action="#" method="GET">
      <div class="input-group">
          <input class="form-control form-control-danger" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-danger rounded-0 border-end" type="submit">Search</button>
      </div>
  </form>

  <!-- Back to Store Link -->
  <div class="navbar-nav">
      <div class="nav-item text-nowrap">
          <a class="nav-link px-3" href="{{ route('home') }}">Back to Store</a>
      </div>
  </div>
</header>
