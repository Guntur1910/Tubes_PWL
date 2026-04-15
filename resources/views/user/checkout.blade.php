@extends('layouts.user')

@section('title', 'Checkout - Essence')

@section('content')
<div class="checkout_area section-padding-80">
    <div class="container">
        <div class="row">

            <div class="col-12 col-lg-6">
                <div class="checkout_details_area mt-50 clearfix">

                    <div class="cart-page-heading mb-30">
                        <h5>Billing Address</h5>
                    </div>

                    <form action="{{ route('user.checkout.process') }}" method="post" id="essenceCheckoutForm" @if($cart->count() === 0) disabled @endif>
                        @csrf
                        <input type="hidden" name="payment_method" value="QRIS">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name">First Name <span>*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ Auth::user()->name }}" required @if($cart->count() === 0) disabled @endif>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name">Last Name <span>*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Nama Belakang" value="" required @if($cart->count() === 0) disabled @endif>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="country">Country <span>*</span></label>
                                <select class="w-100" id="country" name="country" required @if($cart->count() === 0) disabled @endif>
                                    <option value="">-- Pilih Negara --</option>
                                    <option value="idn">Indonesia</option>
                                    <option value="usa">United States</option>
                                    <option value="uk">United Kingdom</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="street_address">Address <span>*</span></label>
                                <input type="text" class="form-control mb-3" id="street_address" name="street_address" placeholder="Jalan, No. Rumah" value="" required @if($cart->count() === 0) disabled @endif>
                                <input type="text" class="form-control" id="street_address2" name="street_address2" placeholder="Kelurahan/Desa, Kecamatan" value="" @if($cart->count() === 0) disabled @endif>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="postcode">Postcode <span>*</span></label>
                                <input type="text" class="form-control" id="postcode" name="postcode" placeholder="e.g., 12345" value="" required @if($cart->count() === 0) disabled @endif>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="city">Town/City <span>*</span></label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="Kota/Kabupaten" value="" required @if($cart->count() === 0) disabled @endif>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="state">Province <span>*</span></label>
                                <input type="text" class="form-control" id="state" name="state" placeholder="Provinsi" value="" required @if($cart->count() === 0) disabled @endif>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="phone_number">Phone No <span>*</span></label>
                                <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="e.g., 082123456789" value="" required @if($cart->count() === 0) disabled @endif>
                            </div>
                            <div class="col-12 mb-4">
                                <label for="email_address">Email Address <span>*</span></label>
                                <input type="email" class="form-control" id="email_address" value="{{ Auth::user()->email }}" readonly>
                            </div>

                            <div class="col-12">
                                <div class="custom-control custom-checkbox d-block mb-2">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="terms" required @if($cart->count() === 0) disabled @endif>
                                    <label class="custom-control-label" for="customCheck1">I agree to Terms and conditions <span class="text-danger">*</span></label>
                                </div>
                                <small class="text-danger" id="termsError" style="display: none;">Anda harus menyetujui syarat dan ketentuan untuk melanjutkan</small>
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

                    @if($cart->count() === 0)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>⚠️ Keranjang Kosong!</strong>
                        <p class="mb-0">Anda belum memilih apapun. Silakan <a href="{{ route('user.shop') }}" class="alert-link">kembali ke toko</a> untuk memilih tiket event.</p>
                    </div>
                    @endif

                    <ul class="order-details-form mb-4" id="cartList">
                        @if($cart->count() > 0)
                        <li><span>Event</span> <span>Jenis Tiket</span> <span>Qty</span> <span>Subtotal</span> <span>Aksi</span></li>
                        
                        {{-- LOOPING ISI KERANJANG --}}
                        @foreach($cart as $item)
                        <li id="item-{{ $item->id }}" class="cart-item">
                            <span class="flex-grow-1">{{ $item->event->name }}</span>
                            <span>{{ $item->ticketType->name ?? '-' }}</span>
                            
                            <div class="qty-control d-inline-flex gap-2">
                                <button type="button" class="btn btn-sm btn-light decrease-qty" data-id="{{ $item->id }}" data-qty="{{ $item->quantity }}" style="padding: 2px 6px; font-size: 12px;">−</button>
                                <span class="qty-display" data-qty="{{ $item->quantity }}">{{ $item->quantity }}</span>
                                <button type="button" class="btn btn-sm btn-light increase-qty" data-id="{{ $item->id }}" data-qty="{{ $item->quantity }}" style="padding: 2px 6px; font-size: 12px;">+</button>
                            </div>
                            
                            <span class="item-total">Rp {{ number_format($item->total_amount, 0, ',', '.') }}</span>
                            
                            <form method="POST" action="{{ route('user.cart.delete', $item->id) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" style="padding: 2px 8px; font-size: 11px; border: none;">🗑️</button>
                            </form>
                        </li>
                        @endforeach

                        <li><span>Subtotal</span> <span></span> <span></span> <span class="cart-subtotal">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span> <span></span></li>
                        <li><span>Shipping</span> <span></span> <span></span> <span>Free</span> <span></span></li>
                        <li><span>Total</span> <span></span> <span></span> <span class="cart-total" style="font-weight: bold; color: #007bff;">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span> <span></span></li>
                        @else
                        <li><span>Keranjang Anda kosong</span></li>
                        @endif
                    </ul>

                    @if($cart->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fa fa-qrcode mr-2"></i>QRIS Payment</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">Pembayaran menggunakan <strong>QRIS</strong> saja. Silakan klik tombol <strong>Bayar dengan QRIS</strong> untuk menyelesaikan transaksi. Sistem akan mensimulasikan proses pembayaran dan langsung mengirimkan e-ticket ke email Anda.</p>
                            <p class="mb-0"><strong>Status transaksi:</strong> <span class="badge badge-secondary">pending</span> → <span class="badge badge-success">paid</span> / <span class="badge badge-danger">failed</span></p>
                        </div>
                    </div>

                    {{-- Tombol dengan validasi form --}}
                    <button type="button" class="btn essence-btn w-100" id="placeOrderBtn" onclick="validateAndSubmitForm()">Bayar dengan QRIS</button>
                    <div id="formErrors" class="alert alert-danger mt-3" style="display: none;"></div>
                    @else
                    <div style="text-align: center; padding: 20px 0;">
                        <a href="{{ route('user.shop') }}" class="btn essence-btn">← Kembali ke Toko</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const decreaseButtons = document.querySelectorAll('.decrease-qty');
    const increaseButtons = document.querySelectorAll('.increase-qty');

    function formatRupiah(value) {
        return value.toLocaleString('id-ID');
    }

    function updateCartTotal() {
        let total = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            const itemTotal = item.querySelector('.item-total');
            const itemTotalText = itemTotal.textContent.replace(/[^\d]/g, '');
            total += parseInt(itemTotalText);
        });

        document.querySelector('.cart-subtotal').textContent = 'Rp ' + formatRupiah(total);
        document.querySelector('.cart-total').textContent = 'Rp ' + formatRupiah(total);
    }

    decreaseButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.id;
            const currentQty = parseInt(this.dataset.qty);
            if (currentQty > 1) {
                updateQuantity(id, currentQty - 1);
            }
        });
    });

    increaseButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.id;
            const currentQty = parseInt(this.dataset.qty);
            updateQuantity(id, currentQty + 1);
        });
    });

    function updateQuantity(transactionId, newQuantity) {
        const url = `/user/cart/${transactionId}/update-quantity`;
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: newQuantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update quantity display
                const item = document.getElementById(`item-${transactionId}`);
                const qtyDisplay = item.querySelector('.qty-display');
                const itemTotal = item.querySelector('.item-total');
                const decreaseBtn = item.querySelector('.decrease-qty');
                const increaseBtn = item.querySelector('.increase-qty');

                qtyDisplay.textContent = newQuantity;
                qtyDisplay.dataset.qty = newQuantity;
                decreaseBtn.dataset.qty = newQuantity;
                increaseBtn.dataset.qty = newQuantity;

                itemTotal.textContent = 'Rp ' + formatRupiah(data.total_amount);

                updateCartTotal();
            }
        })
        .catch(err => console.error('Error:', err));
    }
});

// Fungsi untuk validasi form checkout
function validateAndSubmitForm() {
    // Clear previous errors
    const errorContainer = document.getElementById('formErrors');
    errorContainer.style.display = 'none';
    errorContainer.innerHTML = '';
    
    // Get form elements
    const form = document.getElementById('essenceCheckoutForm');
    const firstName = document.getElementById('first_name');
    const lastName = document.getElementById('last_name');
    const country = document.getElementById('country');
    const streetAddress = document.getElementById('street_address');
    const postcode = document.getElementById('postcode');
    const city = document.getElementById('city');
    const state = document.getElementById('state');
    const phoneNumber = document.getElementById('phone_number');
    const termsCheckbox = document.getElementById('customCheck1');
    
    // Array untuk menyimpan error messages
    const errors = [];
    
    // Validasi setiap field
    if (!firstName.value.trim()) {
        errors.push('First Name wajib diisi');
    }
    if (!lastName.value.trim()) {
        errors.push('Last Name wajib diisi');
    }
    if (!country.value) {
        errors.push('Country wajib dipilih');
    }
    if (!streetAddress.value.trim()) {
        errors.push('Street Address wajib diisi');
    }
    if (!postcode.value.trim()) {
        errors.push('Postcode wajib diisi');
    }
    if (!city.value.trim()) {
        errors.push('City wajib diisi');
    }
    if (!state.value.trim()) {
        errors.push('Province wajib diisi');
    }
    if (!phoneNumber.value.trim()) {
        errors.push('Phone Number wajib diisi');
    }
    if (!termsCheckbox.checked) {
        errors.push('Anda harus menyetujui Terms and Conditions');
    }
    
    // Jika ada error, tampilkan dan jangan submit
    if (errors.length > 0) {
        const errorList = errors.map(err => `<li>${err}</li>`).join('');
        errorContainer.innerHTML = `<ul class="mb-0">${errorList}</ul>`;
        errorContainer.style.display = 'block';
        // Scroll ke top untuk error message terlihat
        errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }
    
    // Jika validasi lolos, submit form
    form.submit();
}

// Real-time validation - hapus error saat user mulai typing
document.addEventListener('DOMContentLoaded', function() {
    const formInputs = ['first_name', 'last_name', 'country', 'street_address', 'postcode', 'city', 'state', 'phone_number', 'customCheck1'];
    formInputs.forEach(inputId => {
        const element = document.getElementById(inputId);
        if (element) {
            const updateValidation = function() {
                const errorContainer = document.getElementById('formErrors');
                if (errorContainer && errorContainer.style.display === 'block') {
                    // Hanya clear error jika semua field sudah terisi
                    const form = document.getElementById('essenceCheckoutForm');
                    const firstName = document.getElementById('first_name');
                    const lastName = document.getElementById('last_name');
                    const country = document.getElementById('country');
                    const streetAddress = document.getElementById('street_address');
                    const postcode = document.getElementById('postcode');
                    const city = document.getElementById('city');
                    const state = document.getElementById('state');
                    const phoneNumber = document.getElementById('phone_number');
                    const termsCheckbox = document.getElementById('customCheck1');
                    
                    if (firstName.value.trim() && lastName.value.trim() && country.value && 
                        streetAddress.value.trim() && postcode.value.trim() && city.value.trim() && 
                        state.value.trim() && phoneNumber.value.trim() && termsCheckbox.checked) {
                        errorContainer.style.display = 'none';
                    }
                }
            };
            
            element.addEventListener('input', updateValidation);
            element.addEventListener('change', updateValidation);
        }
    });
});
</script>

<style>
    .qty-control {
        align-items: center;
    }
    
    .qty-display {
        width: 30px;
        text-align: center;
    }

    .order-details-form li.cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .order-details-form li.cart-item > span:not(.flex-grow-1) {
        min-width: 80px;
        text-align: center;
    }

    input:disabled, select:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>
@endsection