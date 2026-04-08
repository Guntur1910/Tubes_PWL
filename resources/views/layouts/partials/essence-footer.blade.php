<!-- ##### Footer Area Start ##### -->
<footer class="footer_area clearfix">
    <div class="container">
        <div class="row">
            <!-- Logo & Menu -->
            <div class="col-12 col-md-6">
                <div class="single_widget_area d-flex mb-30">
                    <div class="footer-logo mr-50">
                        <a href="{{ route('user.home') }}">
                            <h1>GIGS</h1>
                            {{-- <img src="{{ asset('essence/img/core-img/logo2.png') }}" alt="{{ config('app.name') }}"> --}}
                        </a>
                    </div>
                    <div class="footer_menu">
                        <ul>
                            <li><a href="{{ route('user.shop') }}">Shop</a></li>
                            <li><a href="{{ route('user.blog') }}">Blog</a></li>
                            <li><a href="{{ route('user.contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Links -->
            <div class="col-12 col-md-6">
                <div class="single_widget_area mb-30">
                    <ul class="footer_widget_menu">
                        <li><a href="#">Status Pesanan</a></li>
                        <li><a href="#">Metode Pembayaran</a></li>
                        <li><a href="#">Pengiriman</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row align-items-end">
            <!-- Subscribe -->
            <div class="col-12 col-md-6">
                <div class="single_widget_area">
                    <div class="footer_heading mb-30">
                        <h6>Subscribe</h6>
                    </div>
                    <div class="subscribtion_form">
                        <form action="#" method="post">
                            @csrf
                            <input type="email" name="mail" class="mail" placeholder="Email kamu">
                            <button type="submit" class="submit">
                                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="col-12 col-md-6">
                <div class="single_widget_area">
                    <div class="footer_social_area">
                        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                        <a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
<!-- ##### Footer Area End ##### -->
