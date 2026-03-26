@extends('layouts.user')

@section('title', 'Shop - ' . config('app.name'))

@section('content')

{{-- ===== Shop Area ===== --}}
<div class="shop_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="shop_toolbar_wrapper d-flex justify-content-between align-items-center">
                    <div class="shop_toolbar_btn">
                        <p>Showing 1–12 of 36 results</p>
                    </div>
                    <div class="sorting_wrap">
                        <select class="nice-select">
                            <option value="1">Sort by popularity</option>
                            <option value="2">Sort by average rating</option>
                            <option value="3">Sort by newness</option>
                            <option value="4">Sort by price: low to high</option>
                            <option value="5">Sort by price: high to low</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($products ?? [] as $product)
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-product-wrapper">
                        <!-- Product Image -->
                        <div class="product-img">
                            <img src="{{ $product['image'] ?? asset('essence/img/product-img/product-1.jpg') }}" alt="{{ $product['name'] ?? 'Product' }}">
                            <!-- Hover Thumb -->
                            <img class="hover-img" src="{{ $product['image'] ?? asset('essence/img/product-img/product-2.jpg') }}" alt="{{ $product['name'] ?? 'Product' }}">
                            <!-- Favourite -->
                            <div class="product-favourite">
                                <a href="#" class="favme fa fa-heart"></a>
                            </div>
                        </div>
                        <!-- Product Description -->
                        <div class="product-description">
                            <span>{{ $product['category'] ?? 'Category' }}</span>
                            <a href="{{ route('user.product', $product['id'] ?? 1) }}">
                                <h6>{{ $product['name'] ?? 'Product Name' }}</h6>
                            </a>
                            <p class="product-price">${{ $product['price'] ?? '99.99' }}</p>
                            <!-- Hover Content -->
                            <div class="hover-content">
                                <!-- Add to Cart -->
                                <div class="add-to-cart-btn">
                                    <a href="#" class="btn essence-btn">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>No products available.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                <div class="shop_pagination">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm">
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection