<!-- Header Start -->
<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            {{-- Tombol toggle sidebar (mobile) --}}
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>

            {{-- Notifikasi --}}
            <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ti ti-bell"></i>
                    <div class="notification bg-primary rounded-circle"></div>
                </a>
                <div class="dropdown-menu dropdown-menu-animate-up" aria-labelledby="drop1">
                    <div class="message-body">
                        <a href="javascript:void(0)" class="dropdown-item">Tidak ada notifikasi</a>
                    </div>
                </div>
            </li>
        </ul>

        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                {{-- Profile dropdown --}}
                <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:void(0)" id="drop2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}"
                            alt="profile" width="35" height="35" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            {{-- Nama user dari Laravel Auth --}}
                            <div class="px-3 py-2 border-bottom">
                                <h6 class="mb-0">{{ auth()->user()->name ?? 'Admin' }}</h6>
                                <small class="text-muted">{{ auth()->user()->email ?? '' }}</small>
                            </div>
                            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                <p class="mb-0 fs-3">My Profile</p>
                            </a>
                            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-settings fs-6"></i>
                                <p class="mb-0 fs-3">Settings</p>
                            </a>

                            {{-- Logout --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary mx-3 mt-2 d-block w-auto">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- Header End -->
