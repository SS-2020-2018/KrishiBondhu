@extends('layouts.app')

@section('title', 'Crop Information Hub & Calculator')

@section('content')
<div class="bg-dark text-white py-4 mb-5" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1530595467537-0b5996c41f2d?q=80&w=1470&auto=format&fit=crop') center/cover no-repeat;">
    <div class="container py-3">
        <h2 class="fw-bold text-warning">🌾 Crop Knowledge Base & Soil Advisory</h2>
        <p class="lead mb-0">Access local crop optimization specifications and compute chemical targets instantly.</p>
    </div>
</div>

<div class="container">
    <div class="row g-4">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 sticky-top" style="top: 90px;">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0 fw-bold">🧮 Precision Fertilizer Estimator</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('crophub.calculate') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="crop_type" class="form-label fw-bold">Select Cultivation Crop</label>
                            <select class="form-select" id="crop_type" name="crop_type" required>
                                <option value="" disabled selected>-- Choose target crop --</option>
                                @foreach($crops as $key => $info)
                                    <option value="{{ $key }}" {{ old('crop_type') == $key ? 'selected' : '' }}>{{ $info['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="land_size" class="form-label fw-bold">Total Plot Area Size (Acres)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0.1" class="form-control" id="land_size" name="land_size" placeholder="e.g. 1.5" value="{{ old('land_size') }}" required>
                                <span class="input-group-text bg-light text-muted">Acres</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">Compute Dosage Metrics</button>
                    </form>

                    @if(session('calc_results'))
                        <div class="mt-4 p-3 bg-light border-start border-4 border-warning rounded">
                            <h6 class="fw-bold text-success mb-2">📊 Calculation Output Matrix:</h6>
                            <small class="text-muted d-block mb-3">Allocations tailored for <strong>{{ session('calc_results')['land_size'] }} Acres</strong> of <strong>{{ session('calc_results')['crop_name'] }}</strong>:</small>
                            
                            <div class="d-flex justify-content-between border-bottom py-1 small">
                                <span>🧪 <strong>Urea Fertilizer (Nitrogen)</strong></span>
                                <span class="badge bg-dark fs-6">{{ session('calc_results')['urea'] }} kg</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-1 small">
                                <span>🧪 <strong>TSP Fertilizer (Phosphate)</strong></span>
                                <span class="badge bg-dark fs-6">{{ session('calc_results')['tsp'] }} kg</span>
                            </div>
                            <div class="d-flex justify-content-between py-1 small">
                                <span>🧪 <strong>MOP Fertilizer (Potassium)</strong></span>
                                <span class="badge bg-dark fs-6">{{ session('calc_results')['mop'] }} kg</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <h4 class="fw-bold text-success mb-4">📖 Verified Crop Knowledge Base</h4>
            
            @foreach($crops as $key => $info)
                <div class="card card-body shadow-sm border-0 mb-3 p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                        <h5 class="fw-bold text-dark mb-0">{{ $info['name'] }}</h5>
                        <span class="badge bg-light text-success border border-success px-3 py-2 rounded-pill small">{{ $info['season'] }}</span>
                    </div>
                    
                    <div class="row g-2 small">
                        <div class="col-sm-4 text-muted"><strong>Ideal Soil Context:</strong></div>
                        <div class="col-sm-8 text-dark mb-2">{{ $info['soil'] }}</div>

                        <div class="col-sm-4 text-muted"><strong>Baseline Yields Potential:</strong></div>
                        <div class="col-sm-8 text-dark mb-2"><span class="text-success fw-bold">{{ $info['expected_yield'] }}</span></div>

                        <div class="col-sm-4 text-muted"><strong>Standard Dosage Base:</strong></div>
                        <div class="col-sm-8 text-secondary italic">
                            Urea: {{ $info['base_n'] }}kg/acre | TSP: {{ $info['base_p'] }}kg/acre | MOP: {{ $info['base_k'] }}kg/acre
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection