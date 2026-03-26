@extends('layouts.user')

@section('title', 'Product Details - ' . config('app.name'))

@section('content')

{{-- ===== Product Details Area ===== --}}
<div class="single_product_details_area d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="single_product_thumb">
                    <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <a class="gallery_img" href="{{ $product['image'] ?? asset('essence/img/product-img/product-1.jpg') }}">
                                    <img class="d-block w-100" src="{{ $product['image'] ?? asset('essence/img/product-img/product-1.jpg') }}" alt="First slide">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="single_product_desc">
                    <h4 class="title">{{ $product['name'] ?? 'Product Name' }}</h4>
                    <h4 class="price">${{ $product['price'] ?? '99.99' }}</h4>
                    <p class="available">Available: <span class="text-muted">{{ $product['stock'] ?? 'In Stock' }}</span></p>
                    <div class="short_overview">
                        <p>{{ $product['description'] ?? 'Product description goes here.' }}</p>
                    </div>

                    <form class="cart-form" method="post">
                        @csrf
                        <div class="select-box d-flex mt-50 mb-30">
                            <select name="select" id="productSize" class="mr-5">
                                <option value="value">Size: XL</option>
                                <option value="value">Size: X</option>
                                <option value="value">Size: M</option>
                                <option value="value">Size: S</option>
                            </select>
                            <select name="select" id="productColor">
                                <option value="value">Color: Black</option>
                                <option value="value">Color: White</option>
                                <option value="value">Color: Red</option>
                                <option value="value">Color: Purple</option>
                            </select>
                        </div>

                        <div class="cart-fav-box d-flex align-items-center">
                            <button type="submit" name="addtocart" value="5" class="btn essence-btn">Add to cart</button>
                            <div class="product-favourite ml-4">
                                <a href="#" class="favme fa fa-heart"></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection