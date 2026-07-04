<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Krshi Bondhu - Smart Agriculture')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    @yield('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light kb-navbar sticky-top py-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4 d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('storage/image/agrilogo.png') }}" alt="Krshi Bondhu Logo" class="kb-brand-mark">
            <span>Krshi Bondhu</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link kb-nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link kb-nav-link" href="{{ route('marketplace.index') }}">Agri Market</a></li>
                <li class="nav-item"><a class="nav-link kb-nav-link" href="{{ route('utilities.index') }}">Services</a></li>
                @auth
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link position-relative kb-nav-link" href="#" id="notifDrop" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            🔔 <span class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.65rem;">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0 p-3" aria-labelledby="notifDrop" style="width: 320px;">
                            <h6 class="fw-bold mb-2 pb-1 border-bottom text-dark">Notifications</h6>
                            <div class="overflow-auto mb-2" style="max-height: 200px;">
                                @forelse(Auth::user()->unreadNotifications as $notif)
                                    <div class="p-2 border-bottom small text-secondary">
                                        {{ $notif->data['message'] }}
                                        <span class="d-block text-end font-monospace text-muted mt-1" style="font-size:0.6rem;">{{ $notif->data['time'] }}</span>
                                    </div>
                                @empty
                                    <div class="text-center py-3 text-muted small">No new notifications to display.</div>
                                @endforelse
                            </div>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.clear') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-xs btn-light text-success fw-bold w-100 py-1 font-monospace" style="font-size:0.75rem;">Mark All As Read</button>
                                </form>
                            @endif
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        @php
                            $navProfileImage = Auth::user()->profile_image ?: (Auth::user()->farmerProfile?->profile_image);
                        @endphp
                        <a class="nav-link dropdown-toggle fw-bold kb-nav-link d-flex align-items-center gap-2" href="#" id="userDrop" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if($navProfileImage)
                                <img src="{{ asset('storage/' . $navProfileImage) }}" alt="Profile image" class="kb-avatar">
                            @else
                                <span class="kb-avatar-emoji">🧑</span>
                            @endif
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDrop">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">My Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-bold">Sign Out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item ms-lg-2"><a class="btn btn-outline-success btn-sm px-3 rounded-pill me-2" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="btn btn-success btn-sm px-3 text-white rounded-pill" href="{{ route('register') }}">Join Community</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

    <main class="py-0">
        @yield('content')
    </main>

    <footer class="footer-custom mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>Krshi Bondhu</h5>
                    <p>Empowering modern farmers with unified marketplaces, localized price tracking indicators, and immediate diagnostic pest reports.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Quick Links</h5>
                    <ul style="line-height: 1.8;" >
                        <li><a href="#" style="text-decoration: none;">Privacy Policy</a></li>
                        <li><a href="#" style="text-decoration: none;">Terms of Services</a></li>
                        <li><a href="#" style="text-decoration: none;">FAQ Guidebook</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Contact Support</h5>
                    <p>📞 Helpdesk:01741662609</p>
                    <p>📧 Email: support@krshibondhu.com</p>
                </div>
            </div>
            <hr class="border-secondary">
            <div style="text-align: center; font-size: 0.9rem; color: #6c757d;">
                &copy; 2026 Krshi Bondhu. All Rights Reserved. Built for Agricultural Modernization.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}" defer></script>
    @yield('scripts')
</body>
</html>