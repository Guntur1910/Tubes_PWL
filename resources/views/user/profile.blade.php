@extends('layouts.user')
@section('content')

<style>
    .profile-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
    }
    .profile-cover {
        height: 180px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
    }
    /* Efek transisi halus dari cover ke konten putih */
    .profile-cover::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 30px;
        background: linear-gradient(to top, rgba(255,255,255,1), rgba(255,255,255,0));
    }
    .profile-avatar {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border: 5px solid #ffffff;
        margin-top: -85px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        position: relative;
        z-index: 2;
        transition: transform 0.3s ease;
    }
    .profile-avatar:hover {
        transform: scale(1.05);
    }
    .stat-item {
        transition: background-color 0.2s ease;
        border-radius: 12px;
    }
    .stat-item:hover {
        background-color: #f8f9fa;
    }
    .btn-custom-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-custom-primary:hover {
        background: linear-gradient(135deg, #5a6fd6, #673f91);
        color: white;
        box-shadow: 0 8px 20px rgba(118, 75, 162, 0.4);
        transform: translateY(-2px);
    }
    .btn-custom-danger {
        transition: all 0.3s ease;
    }
    .btn-custom-danger:hover {
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.2);
        transform: translateY(-2px);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card profile-card border-0 shadow-lg rounded-4 overflow-hidden">
                
                {{-- Cover Image/Gradient --}}
                <div class="profile-cover"></div>
                
                {{-- Profile Content --}}
                <div class="card-body text-center position-relative pb-5">
                    
                    {{-- Avatar --}}
                    <img src="{{ auth()->user()->photo 
                        ? asset('storage/profile/' . auth()->user()->photo)
                        : asset('assets/images/profile/user-1.jpg') }}"
                        class="rounded-circle profile-avatar bg-white"
                        alt="Profile Picture">
                    
                    {{-- Name & Email --}}
                    <div class="mt-3 mb-4">
                        <h3 class="mb-1 fw-bolder text-dark">
                            {{ auth()->user()->name }}
                        </h3>
                        <p class="text-muted mb-2 fs-6">
                            {{ auth()->user()->email }}
                        </p>
                        {{-- Badge --}}
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill fw-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-star-fill me-1 mb-1" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            Member
                        </span>
                    </div>

                    {{-- Stats Section (Dibungkus card agar lebih rapi) --}}
                    <div class="d-flex justify-content-center mb-5">
                        <div class="row w-100 text-center mx-3 py-3 border rounded-4 bg-white shadow-sm" style="max-width: 500px;">
                            <div class="col stat-item py-2">
                                <h4 class="fw-bolder mb-1 text-dark">0</h4>
                                <small class="text-muted fw-semibold">Orders</small>
                            </div>
                            <div class="col stat-item py-2 border-start border-end">
                                <h4 class="fw-bolder mb-1 text-dark">0</h4>
                                <small class="text-muted fw-semibold">Wishlist</small>
                            </div>
                            <div class="col stat-item py-2">
                                <h4 class="fw-bolder mb-1 text-dark">0</h4>
                                <small class="text-muted fw-semibold">Reviews</small>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-custom-primary px-4 py-2 rounded-pill fw-semibold d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                            </svg>
                            Edit Profile
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-custom-danger px-4 py-2 rounded-pill fw-semibold d-flex align-items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
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