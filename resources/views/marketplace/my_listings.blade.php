@extends('layouts.app')

@section('title', 'My Commercial Inventory Dashboard')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-success mb-1">🛠️ My Listed Advertisements</h3>
            <p class="text-muted small mb-0">Track and manage the machinery items you have posted on the platform.</p>
        </div>
        <a href="{{ route('marketplace.index') }}" class="btn btn-outline-success btn-sm rounded-pill px-3">← Back to Market</a>
    </div>

    <div class="card shadow-sm border-0 bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Item Details</th>
                        <th>Classification</th>
                        <th>Valuation Price</th>
                        <th>Stock Metrics</th>
                        <th class="pe-4">Listing Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <span class="fs-4 me-3">⚙️</span>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $product->name }}</div>
                                        <small class="text-muted">📍 {{ $product->location }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $product->listing_type == 'rent' ? 'bg-info' : 'bg-warning text-dark' }} text-uppercase px-2 py-1">
                                    {{ $product->listing_type }}
                                </span>
                            </td>
                            <td class="fw-bold text-success">BDT {{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }} units</td>
                            <td class="text-muted pe-4">{{ $product->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                You have not listed any items for sale or rent yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection