@extends('layouts.user')

@section('title', 'Checkout - ' . config('app.name'))

@section('content')

{{-- ===== Checkout Area ===== --}}
<div class="checkout_area section-padding-80">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="checkout_details_area mt-50 clearfix">
                    <div class="cart-page-heading mb-30">
                        <h5>Billing Address</h5>
                    </div>

                    <form action="#" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name">First Name <span>*</span></label>
                                <input type="text" class="form-control" id="first_name" value="" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name">Last Name <span>*</span></label>
                                <input type="text" class="form-control" id="last_name" value="" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="company">Company Name</label>
                                <input type="text" class="form-control" id="company" value="">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="country">Country <span>*</span></label>
                                <select class="w-100" id="country">
                                    <option value="usa">United States</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="ger">Germany</option>
                                    <option value="fra">France</option>
                                    <option value="ind">India</option>
                                    <option value="aus">Australia</option>
                                    <option value="bra">Brazil</option>
                                    <option value="cana">Canada</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="street_address">Address <span>*</span></label>
                                <input type="text" class="form-control mb-3" id="street_address" placeholder="Street Address" value="">
                                <input type="text" class="form-control" id="street_address2" placeholder="Apartment, suite, unit etc. (optional)" value="">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="postcode">Postcode / Zip <span>*</span></label>
                                <input type="text" class="form-control" id="postcode" placeholder="Postcode / Zip" value="">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="city">Town / City <span>*</span></label>
                                <input type="text" class="form-control" id="city" placeholder="Town / City" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state">Province <span>*</span></label>
                                <input type="text" class="form-control" id="state" placeholder="Province" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone_number">Phone No <span>*</span></label>
                                <input type="number" class="form-control" id="phone_number" min="0" value="">
                            </div>
                            <div class="col-12 mb-4">
                                <label for="email_address">Email Address <span>*</span></label>
                                <input type="email" class="form-control" id="email_address" placeholder="Email Address" value="">
                            </div>

                            <div class="col-12">
                                <div class="custom-control custom-checkbox d-block mb-2">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Terms and conditions</label>
                                </div>
                                <div class="custom-control custom-checkbox d-block mb-2">
                                    <input type="checkbox" class="custom-control-input" id="customCheck2">
                                    <label class="custom-control-label" for="customCheck2">Subscribe to our newsletter</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="order-details-confirmation">
                    <div class="cart-page-heading">
                        <h5>Your Order</h5>
                        <p>The Details</p>
                    </div>

                    <ul class="order-details-form mb-4">
                        <li><span>Product</span> <span>Total</span></li>
                        @forelse($cart ?? [] as $item)
                            <li><span>{{ $item['name'] ?? 'Product' }}</span> <span>${{ $item['price'] ?? '0' }}</span></li>
                        @empty
                            <li><span>No items in cart</span> <span>$0</span></li>
                        @endforelse
                        <li><span>Subtotal</span> <span>$0</span></li>
                        <li><span>Shipping</span> <span>$0</span></li>
                        <li><span>Total</span> <span>$0</span></li>
                    </ul>

                    <div id="accordion" role="tablist" class="mb-4">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne">
                                <h6 class="mb-0">
                                    <a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne"><i class="fa fa-circle-o mr-3"></i>Paypal</a>
                                </h6>
                            </div>

                            <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integ er bibendum sodales arcu id te mpus. Ut consectetur lacus.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingTwo">
                                <h6 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="fa fa-circle-o mr-3"></i>cash on delievery</a>
                                </h6>
                            </div>
                            <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quis in veritatis officia inventore, tempore provident dignissimos.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree">
                                <h6 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><i class="fa fa-circle-o mr-3"></i>credit card</a>
                                </h6>
                            </div>
                            <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse quo sint repudiandae suscipit ab soluta delectus voluptate, vero vitae</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingFour">
                                <h6 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour"><i class="fa fa-circle-o mr-3"></i>direct bank transfer</a>
                                </h6>
                            </div>
                            <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est cum autem eveniet saepe fugit aperiam sequi optio consectetur. Numquam eaque voluptatibus</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="btn essence-btn btn-block">Place Order</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection