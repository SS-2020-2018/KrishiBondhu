@extends('layouts.app')

@section('title', $product->name . ' - Technical Specifications')

@section('content')
<div class="container my-5">
    <a href="{{ route('marketplace.index') }}" class="btn btn-link text-success p-0 mb-4 fw-bold text-decoration-none">← Return back to catalog gallery</a>

    @if(session('success'))
        <div class="alert alert-success shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 overflow-hidden mb-5">
        <div class="row g-0">
            <div class="col-md-5 bg-light d-flex align-items-center justify-content-center border-end">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid w-100 h-100" style="object-fit: cover; max-height: 450px;" alt="Visual Matrix">
                @else
                    <div class="text-center py-5 my-5 text-muted"><span class="fs-1 d-block">🚜</span> No product image metrics.</div>
                @endif
            </div>

            <div class="col-md-7 p-5">
                <span class="badge {{ $product->listing_type == 'rent' ? 'bg-info' : 'bg-warning text-dark' }} text-uppercase px-3 py-2 mb-3 fw-bold">
                    {{ $product->listing_type == 'rent' ? 'Available for Rent' : 'Available for Purchase' }}
                </span>
                <h2 class="fw-bold text-dark mb-1">{{ $product->name }}</h2>
                <p class="text-success small fw-bold mb-4">📍 Stored at: {{ $product->location }}</p>

                <div class="bg-light p-4 rounded mb-4">
                    <span class="text-muted small d-block">Price Point Demanded</span>
                    <h2 class="text-success fw-bold mb-0">BDT {{ number_format($product->price, 2) }}</h2>
                </div>

                <h5 class="fw-bold mb-2">Technical Specifications:</h5>
                <p class="text-muted mb-4">{{ $product->description }}</p>

                <div class="card p-3 bg-white border border-light shadow-sm">
                    <h6 class="fw-bold text-muted mb-2">🧑‍💼 Owner/Vendor Information</h6>
                    <p class="mb-2 text-dark"><strong>Listed By:</strong> {{ $product->user->name }}</p>
                    
                    @if(Auth::id() !== $product->user_id)
                        <a href="{{ route('chat.room', $product->user_id) }}" class="btn btn-sm btn-outline-success fw-bold px-4 rounded-pill mt-2">💬 Secure Live Chat with Owner</a>
                    @else
                        <span class="badge bg-light text-secondary border py-2 mt-2">This is your product listing ad.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-5">
            <div class="card card-body shadow-sm border-0 p-4 bg-white">
                <h5 class="fw-bold text-dark mb-3">⭐ Submit Your Experience Review</h5>
                <form action="{{ route('review.store', $product->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Star Grade Evaluation Mapping</label>
                        <select name="rating" class="form-select text-warning fw-bold" required>
                            <option value="5" class="text-warning">⭐⭐⭐⭐⭐ Excellent (5 Stars)</option>
                            <option value="4">⭐⭐⭐⭐ Good (4 Stars)</option>
                            <option value="3">⭐⭐⭐ Average (3 Stars)</option>
                            <option value="2">⭐⭐ Poor (2 Stars)</option>
                            <option value="1">⭐ Terrible (1 Star)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Commentary Feedback Notes</label>
                        <textarea name="comment" class="form-control" rows="3" placeholder="Share tool efficiency notes or seller transparency details..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm w-100 fw-bold">Publish Review</button>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <h5 class="fw-bold text-dark mb-3">💬 Client Reviews Catalog Matrix ({{ $product->reviews->count() }})</h5>
            <div class="list-group list-group-flush border rounded bg-white shadow-sm">
                @forelse($product->reviews as $review)
                    <div class="list-group-item p-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong class="text-success small">{{ $review->user->name }}</strong>
                            <span class="text-warning fw-bold small">
                                {{ str_repeat('⭐', $review->rating) }}
                            </span>
                        </div>
                        <p class="text-muted small mb-0 font-monospace">{{ $review->comment }}</p>
                        <small class="text-muted font-monospace d-block text-end" style="font-size: 0.7rem;">Posted on: {{ $review->created_at->format('M d, Y') }}</small>
                    </div>
                @empty
                    <p class="text-muted small text-center p-4 mb-0">No rating data points published on this equipment yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection