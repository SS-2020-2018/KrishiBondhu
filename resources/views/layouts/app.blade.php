<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Krshi Bondhu - Smart Agriculture')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --agri-green: #2e7d32;
            --agri-gold: #fbc02d;
            --agri-dark: #1b5e20;
        }
        .navbar-custom {
            background-color: var(--agri-green);
        }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link {
            color: #ffffff !important;
        }
        .navbar-custom .nav-link:hover {
            color: var(--agri-gold) !important;
        }
        .footer-custom {
            background-color: #212121;
            color: #e0e0e0;
            padding: 40px 0;
        }
    </style>
    @yield('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <span class="fw-bold fs-4">🚜 Krshi Bondhu</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#services-section">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('help') }}">Help</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    @auth
                        @if(Auth::user()->role === 'farmer')
                            <a href="{{ route('profile.farmer') }}" class="btn btn-outline-light me-3">My Profile</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger px-3 rounded-pill">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-warning fw-bold px-4 rounded-pill">Join Us</a>
                    @endauth
                </div>
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
                    <p class="small text-muted">Empowering modern farmers with unified marketplaces, localized price tracking indicators, and immediate diagnostic pest reports.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled small">
                        <li><a href="#" class="text-decoration-none text-muted">Privacy Policy</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Terms of Services</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">FAQ Guidebook</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Contact Support</h5>
                    <p class="small text-muted mb-1">📞 Helpdesk: +880 1700-000000</p>
                    <p class="small text-muted">📧 Email: support@krshibondhu.com</p>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center small text-muted">
                &copy; 2026 Krshi Bondhu. All Rights Reserved. Built for Agricultural Modernization.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>