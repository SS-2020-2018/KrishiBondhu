@extends('layouts.app')

@section('title', 'Agricultural Marketplace - Krshi Bondhu')

@section('content')
<div class="bg-light py-4 border-bottom">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <h2 class="fw-bold text-success mb-1">🚜 Machinery & Tools Hub</h2>
                <p class="text-muted small mb-0">Browse modern tools available for purchase or rental across local sectors.</p>
            </div>
            @if(in_array(Auth::user()->role, ['farmer', 'seller']))
                <div class="mt-3 mt-md-0">
                    <a href="{{ route('marketplace.create') }}" class="btn btn-success fw-bold px-4 rounded-pill">+ List New Equipment</a>
                    <a href="{{ route('marketplace.mine') }}" class="btn btn-outline-success fw-bold px-3 rounded-pill ms-2">My Current Ads</a>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="container my-5">
    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif

    <div class="card card-body border-0 shadow-sm mb-5 p-4 bg-white">
        <form action="{{ route('marketplace.index') }}" method="GET" class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Search Equipment</label>
                <input type="text" name="search" class="form-control" placeholder="What tools are you looking for?" value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Deal Framework</label>
                <select name="listing_type" class="form-select">
                    <option value="">All Categories</option>
                    <option value="sell" {{ request('listing_type') == 'sell' ? 'selected' : '' }}>For Sale (ক্রয়)</option>
                    <option value="rent" {{ request('listing_type') == 'rent' ? 'selected' : '' }}>For Rent (ভাড়া)</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-warning w-100 fw-bold">Filter Items</button>
            </div>
        </form>
    </div>

    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 position-relative">
                    <span class="position-absolute top-0 end-0 badge {{ $product->listing_type == 'rent' ? 'bg-info' : 'bg-warning text-dark' }} m-3 px-3 py-2 text-uppercase fw-bold">
                        {{ $product->listing_type == 'rent' ? 'For Rent' : 'For Sale' }}
                    </span>
                    
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Equipment Photo">
                    @else
                        <div class="bg-light text-center py-5 border-bottom text-muted" style="height: 200px;">
                            <span class="fs-1 d-block mt-3">⚙️</span> No Photo Attached
                        </div>
                    @endif

                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-dark mb-1">{{ $product->name }}</h5>
                        <p class="text-muted small mb-3">📍 Location: {{ $product->location }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <div>
                                <span class="text-secondary small d-block">Price Point</span>
                                <h4 class="text-success fw-bold mb-0">BDT {{ number_format($product->price, 2) }} <span class="fs-6 text-muted fw-normal">{{ $product->listing_type == 'rent' ? '/day' : '' }}</span></h4>
                            </div>
                            <a href="{{ route('marketplace.show', $product->id) }}" class="btn btn-sm btn-success px-3 fw-bold">Details View</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <span class="fs-1">🌾</span>
                <h4 class="mt-3 fw-bold text-muted">No equipment matching your search is currently listed.</h4>
            </div>
        @endforelse
    </div>
</div>
@endsection