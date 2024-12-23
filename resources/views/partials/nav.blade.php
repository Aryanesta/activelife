{{-- @dd($categories) --}}

<header>
    <div class="head bg-danger text-white p-3">
        <h1 id="brand">ActiveLife</h1>
        <div class="search-bar">
            {{-- Toggler Btn --}}
            <button id="nav-toggler" type="button" class="navbar-toggler p-0" data-bs-toggle="collapse">
                <span class="bi bi-list text-white" style="font-size: 30px;"></span>
            </button>
            {{-- Toggler Btn End --}}

            {{-- Search Bar --}}
            <form action="{{ route('searchProducts') }}" method="POST" class="input-group mb-3 h-50 ms-2 search">
                <input type="text" class="form-control border-0 p-3" placeholder="Search.." name="query-input" value="{{ $queryInput ?? '' }}">
                @csrf
                <button class="btn btn-outline-light border-light text-white" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

        </div>
        <div class="right-head gap-4">
            {{-- Keranjang --}}
            <div class="d-flex" style="position: relative">
                <a href="{{ route('cart.index') }}" class="text-white"><i class="bi bi-cart3" id="cart-screen-toggler"></i>
                    <div class="bg-warning d-flex justify-content-center align-items-center" id="cart-quantity" style="font-size: 0.7rem">
                        {{-- @dd($cartQuantity) --}}
                        {{ $cartQuantity }}
                    </div>
                </a>

            </div>
            {{-- Keranjang End --}}
            <div class="dropdown">
                <span type="button" class="dropdown-toggle text-white d-flex align-items-center" data-bs-toggle="dropdown" id="button-profile">
                    <i class="bi bi-person" id="icon-profile"></i> <span id="username">{{ auth()->user() ? auth()->user()->username : 'Account' }}</span>
                </span>
                <ul class="dropdown-menu">
                    @auth
                        @if (auth()->user()->is_admin == true)
                            <li>
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark" style="font-size: 1rem">
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-house"></i> Dashboard
                                    </button>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                        @endif
                    <!-- Menu Logout -->
                    <li>
                        <a href="{{ route('profile') }}" class="text-decoration-none text-dark" style="font-size: 1rem">
                            <button type="submit" class="dropdown-item"><i class="bi bi-person-circle"></i> Profile</button>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('transaction-history') }}" class="text-decoration-none text-dark" style="font-size: 1rem">
                            <button type="submit" class="dropdown-item"><i class="bi bi-clock-history"></i> Transaction History</button>
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="bi bi-arrow-left-square"></i> Logout</button>
                        </form>
                    </li>
                    @else
                    <li>
                        <a href="{{ route('login') }}" class="text-decoration-none text-dark" style="font-size: 1rem"><button type="submit" class="dropdown-item"><i class="bi bi-arrow-right-square"></i> Login</button></a>
                    </li>
                    @endauth                    
                </ul>
            </div>        
        </div>
    </div>
    
    {{-- Navigasi --}}
    <nav class="p-3 border-bottom border nav">
        <span class="nav-item">
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
        </span>
        <span class="nav-item">
            <a href="/product" class="nav-link {{ request()->is('product') ? 'active' : '' }}">Product</a>
        </span>
        <div class="dropdown" id="category-nav">
            <span href="#" class="nav-link dropdown-toggle {{ request()->is('product-category/*') ? 'active' : '' }}" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Category
            </span>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                @foreach ($categories as $category)
                <li>
                    <a class="dropdown-item" 
                        href="/product-category/{{ $category->id }}">
                        {{ $category->category_name }}
                    </a>
                </li>
            @endforeach
            </ul>
          </div>
        <span class="nav-item">
            <a href="{{ route('contact') }}" class="nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a>
        </span>
    </nav>


</header>