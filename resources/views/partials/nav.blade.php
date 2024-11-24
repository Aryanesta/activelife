<header>
    <div class="head bg-danger text-white p-3">
        <h1 id="brand">ActiveLife</h1>
        <div class="search-bar">
            {{-- Toggler Btn --}}
            <button id="nav-toggler" type="button" class="navbar-toggler p-0" data-bs-toggle="collapse">
                <span class="bi bi-list text-white" style="font-size: 30px;"></span>
            </button>
            {{-- Toggler Btn End --}}

            <form action="" class="input-group mb-3 h-50 ms-2 search">
                <input type="text" class="border-0 p-3" placeholder="Search..">
                <button class="btn btn-outline-light border-light text-white" type="button"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <div class="right-head">
            {{-- Keranjang --}}
            <div class="d-flex bg-black" style="position: relative">
                <a href="{{ route('cart.index') }}" class="text-white"><i class="bi bi-cart3" id="cart-screen-toggler"></i>
                    <div class="bg-warning d-flex justify-content-center align-items-center" id="cart-quantity" style="font-size: 0.7rem">
                        {{-- @dd($cartQuantity) --}}
                        {{ $cartQuantity }}
                    </div>
                </a>

            </div>
            {{-- Keranjang End --}}
            <div class="dropdown">
                <button type="button" class="btn dropdown-toggle text-white d-flex align-items-center" data-bs-toggle="dropdown" id="button-profile">
                    <i class="bi bi-person" id="icon-profile"></i> <span id="username">{{ auth()->user() ? auth()->user()->name : 'Account' }}</span>
                </button>
                <ul class="dropdown-menu">
                    @auth
                    <li>
                        <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark" style="font-size: 1rem">
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-house"></i> Dashboard
                            </button>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <!-- Menu Logout -->
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
            <span class="nav-item"><a href="#" class="nav-link">Category</a></span>
            <span class="nav-item"><a href="#" class="nav-link">Promo</a></span>
            <span class="nav-item"><a href="#" class="nav-link">Article</a></span>
            <span class="nav-item"><a href="#" class="nav-link">Contact</a></span>
    </nav>
</header>

{{-- <div class="bg-light border p-3" id="cart-screen">
    <h4>Your Cart</h4>
</div> --}}