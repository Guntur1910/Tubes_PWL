@extends('layouts.user')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                {{-- Cover --}}
                <div style="height:150px; background: linear-gradient(135deg, #667eea, #764ba2);"></div>

                {{-- Profile Content --}}
                <div class="card-body text-center position-relative">

                    <img src="{{ auth()->user()->photo 
                        ? asset('storage/profile/' . auth()->user()->photo)
                        : asset('assets/images/profile/user-1.jpg') }}"
                        class="rounded-circle border border-4 border-white shadow"
                        width="120"
                        style="margin-top:-80px; object-fit:cover; height:120px;">

                    {{-- Name --}}
                    <h3 class="mt-3 mb-0 fw-bold">
                        {{ auth()->user()->name }}
                    </h3>

                    {{-- Email --}}
                    <p class="text-muted mb-3">
                        {{ auth()->user()->email }}
                    </p>

                    {{-- Badge --}}
                    <span class="badge bg-primary px-3 py-2 mb-3">
                        Member
                    </span>

                    <hr>

                    {{-- Info --}}
                    <div class="row text-center mb-4">
                        <div class="col">
                            <h5 class="fw-bold mb-0">0</h5>
                            <small class="text-muted">Orders</small>
                        </div>
                        <div class="col">
                            <h5 class="fw-bold mb-0">0</h5>
                            <small class="text-muted">Wishlist</small>
                        </div>
                        <div class="col">
                            <h5 class="fw-bold mb-0">0</h5>
                            <small class="text-muted">Reviews</small>
                        </div>
                    </div>

                    {{-- Button --}}
                    <div class="d-flex justify-content-center gap-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary px-4 rounded-pill">
                            Edit Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-outline-danger rounded-pill">
                                Logout
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection