
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('dashboard') }}">
              <i class="bi bi-house"></i> <!-- Ikon Dashboard -->
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('product.index') ? 'active' : '' }}" href="{{ route('product.index') }}">
              <i class="bi bi-cart"></i> <!-- Ikon Products -->
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('category.index') ? 'active' : '' }}" href="{{ route('category.index') }}">
              <i class="bi bi-basket"></i> <!-- Ikon Category -->
              Category
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-people"></i> <!-- Ikon Customers -->
              Customers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('transaction.index') ? 'active' : '' }}" href="{{ route('transaction.index') }}">
              <i class="bi bi-bar-chart"></i> <!-- Ikon Transaction -->
              Transaction
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-layers"></i> <!-- Ikon Integrations -->
              Integrations
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <i class="bi bi-plus-circle"></i> <!-- Ikon Add New Report -->
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-file-text"></i> <!-- Ikon Current month -->
              Current month
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-file-text"></i> <!-- Ikon Last quarter -->
              Last quarter
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-file-text"></i> <!-- Ikon Social engagement -->
              Social engagement
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-file-text"></i> <!-- Ikon Year-end sale -->
              Year-end sale
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
