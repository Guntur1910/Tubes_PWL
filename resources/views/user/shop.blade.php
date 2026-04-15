@extends('layouts.user')

@section('title', 'Shop - Essence')

@section('content')
<div class="breadcumb_area bg-img" style="background-image: url({{ asset('essence/img/bg-img/breadcumb.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>Event List</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="shop_grid_area section-padding-80">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="shop_grid_product_area">
                    <div class="row">
                        <div class="col-12">
                            <div class="product-topbar d-flex align-items-center justify-content-between">
                                <div class="total-products">
                                    <p><span>{{ $events->count() }}</span> events found</p>
                                </div>
                                <div class="product-sorting d-flex">
                                    <p>Sort by:</p>
                                    <form action="#" method="get">
                                        <select name="select" id="sortByselect">
                                            <option value="value">Highest Rated</option>
                                            <option value="value">Newest</option>
                                            <option value="value">Price: $$ - $</option>
                                            <option value="value">Price: $ - $$</option>
                                        </select>
                                        <input type="submit" class="d-none" value="">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @forelse($events as $event)
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-product-wrapper">
                                <div class="product-img">
                                    <img src="{{ asset('essence/img/product-img/product-1.jpg') }}" alt="">
                                    <img class="hover-img" src="{{ asset('essence/img/product-img/product-2.jpg') }}" alt="">

                                    <div class="product-favourite">
                                        <a href="#" class="favme fa fa-heart"></a>
                                    </div>
                                </div>

                                <div class="product-description">
                                    <span>{{ $event->location }}</span>
                                    <a href="{{ route('user.event', $event->id) }}">
                                        <h6>{{ $event->name }}</h6>
                                    </a>
                                    <p class="mb-1 text-muted"><small>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} • {{ $event->location }}</small></p>
                                    <p class="product-price">Rp {{ number_format($event->price, 0, ',', '.') }}</p>

                                    <div class="hover-content">
                                        <div class="add-to-cart-btn">
                                            <a href="{{ route('user.event', $event->id) }}" class="btn essence-btn">View Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center">
                            <p>No events available at the moment.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                
                <nav aria-label="navigation">
                    <ul class="pagination mt-50 mb-70">
                        <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>
@endsection