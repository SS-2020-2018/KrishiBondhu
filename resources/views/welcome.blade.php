@extends('layouts.app')

@section('title', 'Krshi Bondhu - Smart Agriculture Support & Marketplace')

@section('content')
<div id="agriBannerCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1500937386664-56d1dfef3854?q=80&w=1470&auto=format&fit=crop') center/cover no-repeat; height: 450px;">
            <div class="container h-100 d-flex flex-column justify-content-center text-white">
                <h1 class="display-4 fw-bold">Smart Agriculture Support Platform</h1>
                <p class="lead">Connecting farmers with modern machinery, real-time market valuations, and expert diagnostic care.</p>
                <div>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-warning btn-lg fw-bold rounded-pill px-4">Get Started Today</a>
                    @else
                        <a href="#services-section" class="btn btn-warning btn-lg fw-bold rounded-pill px-4">Explore Dashboard Services</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5" id="services-section">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-success">Our Core Agricultural Services</h2>
        <p class="text-muted">Digital solutions designed explicitly to scale up traditional farming productivity</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <span class="fs-1">🚜</span>
                    <h5 class="card-title fw-bold mt-3">Machinery Marketplace</h5>
                    <p class="card-text text-muted small">Buy, sell, or rent high-grade farming tools like tractors, seeders, and crop sprayers seamlessly.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <span class="fs-1">🌾</span>
                    <h5 class="card-title fw-bold mt-3">Crop Information Hub</h5>
                    <p class="card-text text-muted small">Access localized soil requirements, active plantation timelines, and ideal fertilizer calculations.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <span class="fs-1">☀️</span>
                    <h5 class="card-title fw-bold mt-3">Live Weather Radar</h5>
                    <p class="card-text text-muted small">Monitor precipitation percentages and local storm warnings to safeguard your irrigation cycles.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection