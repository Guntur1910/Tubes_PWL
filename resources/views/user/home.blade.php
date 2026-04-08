@extends('layouts.user')

@section('title', 'Home - ' . config('app.name'))

@section('content')

{{-- ===== Hero / Welcome Area ===== --}}
<section class="welcome_area" style="height: 350px; min-height: 350px;">
    
    {{-- Atribut data-ride="carousel" memastikan otomatis jalan sejak halaman dimuat --}}
    <div id="heroCarousel" class="carousel slide h-100" data-ride="carousel" data-interval="4000">
        
        <div class="carousel-inner h-100">
            
            {{-- SLIDE 1 --}}
            <div class="carousel-item active h-100 bg-img background-overlay" 
                 style="background-image: url({{ asset('essence/img/bg-img/konser1.jpg') }});">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-12">
                            <div class="hero-content">
                                <h6>{{ $heroSubtitle ?? 'New Season' }}</h6>
                                <h2>{{ $heroTitle ?? 'New Collection' }}</h2>
                                <a href="{{ route('user.shop') }}" class="btn essence-btn">Lihat Tiket</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SLIDE 2 --}}
            <div class="carousel-item h-100 bg-img background-overlay" 
                 style="background-image: url({{ asset('essence/img/bg-img/konser2.jpg') }});">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-12">
                            <div class="hero-content">
                                <h6>{{ $heroSubtitle ?? 'New Season' }}</h6>
                                <h2>{{ $heroTitle ?? 'New Collection' }}</h2>
                                <a href="{{ route('user.shop') }}" class="btn essence-btn">Lihat Tiket</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- SLIDE 3 --}}
            <div class="carousel-item h-100 bg-img background-overlay" 
                 style="background-image: url({{ asset('essence/img/bg-img/konser3.jpg') }});">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-12">
                            <div class="hero-content">
                                <h6>{{ $heroSubtitle ?? 'New Season' }}</h6>
                                <h2>{{ $heroTitle ?? 'New Collection' }}</h2>
                                <a href="{{ route('user.shop') }}" class="btn essence-btn">Lihat Tiket</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== PANAH NAVIGASI ===== --}}
        {{-- Panah Kiri --}}
        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev" style="z-index: 99;">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        
        {{-- Panah Kanan --}}
        <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next" style="z-index: 99;">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

    </div>
</section>

{{-- ===== Produk Populer ===== --}}
<section class="new_arrivals_area section-padding-80 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center">
                    <h2>Paling Populer</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="popular-products-slides owl-carousel">

                    @forelse($popularProducts ?? [] as $product)
                    <div class="single-product-wrapper">
                        <div class="product-img">
                            <img src="{{ asset('essence/img/product-img/' . $product->image) }}" alt="{{ $product->name }}">
                            <img class="hover-img" src="{{ asset('essence/img/product-img/' . ($product->image_hover ?? $product->image)) }}" alt="">

                            @if($product->badge)
                            <div class="product-badge {{ $product->badge_type ?? 'offer-badge' }}">
                                <span>{{ $product->badge }}</span>
                            </div>
                            @endif

                            <div class="product-favourite">
                                <a href="#" class="favme fa fa-heart"></a>
                            </div>
                        </div>
                        <div class="product-description">
                            <span>{{ $product->brand }}</span>
                            <a href="{{ route('user.product', $product->id) }}">
                                <h6>{{ $product->name }}</h6>
                            </a>
                            <p class="product-price">
                                @if($product->old_price)
                                    <span class="old-price">${{ $product->old_price }}</span>
                                @endif
                                ${{ $product->price }}
                            </p>
                            <div class="hover-content">
                                <div class="add-to-cart-btn">
                                    <a href="{{ route('user.cart.add', $product->id) }}" class="btn essence-btn">
                                        Tambah ke Keranjang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    {{-- Data dummy jika belum ada produk di database --}}
                    @for($i = 1; $i <= 4; $i++)
                    <div class="single-product-wrapper">
                        <div class="product-img">
                            <img src="{{ asset('essence/img/product-img/product-' . $i . '.jpg') }}" alt="Produk">
                            <img class="hover-img" src="{{ asset('essence/img/product-img/product-' . ($i % 4 + 1) . '.jpg') }}" alt="">
                            <div class="product-favourite">
                                <a href="#" class="favme fa fa-heart"></a>
                            </div>
                        </div>
                        <div class="product-description">
                            <span>Brand</span>
                            <a href="#"><h6>Nama Produk {{ $i }}</h6></a>
                            <p class="product-price">$80.00</p>
                            <div class="hover-content">
                                <div class="add-to-cart-btn">
                                    <a href="#" class="btn essence-btn">Tambah ke Keranjang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</section>
{{-- ===== CTA Banner ===== --}}
<div class="cta-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cta-content bg-img background-overlay"
                    style="background-image: url({{ asset('essence/img/bg-img/projectpop.jpg') }});">
                    <div class="h-100 d-flex align-items-center justify-content-end">
                        <div class="cta--text">
                            <h6>-60%</h6>
                            <h2>Global Sale</h2>
                            <a href="{{ route('user.shop') }}" class="btn essence-btn">Beli Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- ===== Brand Logos ===== --}}
<div class="brands-area d-flex align-items-center justify-content-between">
    @for($i = 1; $i <= 6; $i++)
    <div class="single-brands-logo">
        <img src="{{ asset('essence/img/core-img/brand' . $i . '.png') }}" alt="Brand {{ $i }}">
    </div>
    @endfor
</div>

@endsection
