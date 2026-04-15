<!-- ##### Header Area Start ##### -->
<header class="header_area">
    <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
        <!-- Classy Menu -->
        <nav class="classy-navbar" id="essenceNav">

            <!-- Logo -->
            <a class="nav-brand" href="{{ route('user.home') }}">
                <h1>GIGS</h1>
                {{-- <img src="{{ asset('essence/img/core-img/logo.png') }}" alt="{{ config('app.name') }}"> --}}
            </a>

            <!-- Navbar Toggler -->
            <div class="classy-navbar-toggler">
                <span class="navbarToggler"><span></span><span></span><span></span></span>
            </div>

            <!-- Menu -->
            <div class="classy-menu">
                <!-- Close btn -->
                <div class="classycloseIcon">
                    <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                </div>

                <!-- Nav Start -->
                <div class="classynav">
                    <ul>
                        <li><a href="{{ route('user.home') }}" class="{{ request()->routeIs('user.home') ? 'active' : '' }}">Home</a></li>
                        <li><a href="{{ route('user.shop') }}" class="{{ request()->routeIs('user.shop') ? 'active' : '' }}">Shop</a></li>
                        <li><a href="{{ route('user.blog') }}" class="{{ request()->routeIs('user.blog*') ? 'active' : '' }}">Blog</a></li>
                        <li><a href="{{ route('user.contact') }}" class="{{ request()->routeIs('user.contact') ? 'active' : '' }}">Contact</a></li>
                    </ul>
                </div>
                <!-- Nav End -->
            </div>
        </nav>

        <!-- Header Meta Data -->
        <div class="header-meta d-flex clearfix justify-content-end">

            <!-- Search -->
            <div class="search-area">
                <form action="{{ route('user.shop') }}" method="GET">
                    <input type="search" name="search" id="headerSearch"
                        placeholder="Cari konser..."
                        value="{{ request('search') }}">
                    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>

            <!-- Favourite -->
            <div class="favourite-area">
                <a href="#"><img src="{{ asset('essence/img/core-img/heart.svg') }}" alt="Wishlist"></a>
            </div>

            <!-- User Login -->
            <div class="user-login-info">
                @auth
                    <div class="dropdown">
                        <a href="#" data-toggle="dropdown">
                            <img src="{{ asset('essence/img/core-img/user.svg') }}" alt="User">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <span class="dropdown-item-text">{{ auth()->user()->name }}</span>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('profile') }}">Profil Saya</a>                            
                            <a class="dropdown-item" href="{{ route('user.tickets') }}">Pesanan Saya</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}">
                        <img src="{{ asset('essence/img/core-img/user.svg') }}" alt="Login">
                    </a>
                @endauth
            </div>

            <!-- Cart -->
            <div class="cart-area">
                <a href="#" id="essenceCartBtn">
                    <img src="{{ asset('essence/img/core-img/bag.svg') }}" alt="Cart">
                    <span>{{ session('cart') ? count(session('cart')) : 0 }}</span>
                </a>
            </div>
        </div>
    </div>
</header>
<!-- ##### Header Area End ##### -->
