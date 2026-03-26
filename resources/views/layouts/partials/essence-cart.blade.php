<!-- ##### Right Side Cart Area ##### -->
<div class="cart-bg-overlay"></div>

<div class="right-side-cart-area">

    <!-- Cart Button -->
    <div class="cart-button">
        <a href="#" id="rightSideCart">
            <img src="{{ asset('essence/img/core-img/bag.svg') }}" alt="Cart">
            <span>{{ session('cart') ? count(session('cart')) : 0 }}</span>
        </a>
    </div>

    <div class="cart-content d-flex">

        <!-- Cart List -->
        <div class="cart-list">
            @forelse(session('cart', []) as $item)
            <div class="single-cart-item">
                <a href="#" class="product-image">
                    <img src="{{ asset('essence/img/product-img/' . $item['image']) }}"
                        class="cart-thumb" alt="{{ $item['name'] }}">
                    <div class="cart-item-desc">
                        <span class="product-remove"><i class="fa fa-close" aria-hidden="true"></i></span>
                        <h6>{{ $item['name'] }}</h6>
                        <p class="price">${{ $item['price'] }}</p>
                    </div>
                </a>
            </div>
            @empty
            <div class="p-3 text-center">
                <p>Keranjang kosong</p>
            </div>
            @endforelse
        </div>

        <!-- Cart Summary -->
        <div class="cart-amount-summary">
            <h2>Summary</h2>
            <ul class="summary-table">
                <li><span>subtotal:</span> <span>${{ collect(session('cart', []))->sum('price') }}</span></li>
                <li><span>delivery:</span> <span>Free</span></li>
                <li><span>total:</span> <span>${{ collect(session('cart', []))->sum('price') }}</span></li>
            </ul>
            <div class="checkout-btn mt-100">
                <a href="{{ route('user.checkout') }}" class="btn essence-btn">Check Out</a>
            </div>
        </div>

    </div>
</div>
<!-- ##### Right Side Cart End ##### -->
