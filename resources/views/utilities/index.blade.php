@extends('layouts.app')

@section('title', 'Smart Agri Utilities Dashboard')

@section('content')
<div class="container my-5">
    <div class="mb-5 text-center">
        <h2 class="fw-bold text-success">⚙️ Smart Agricultural Utilities Engine</h2>
        <p class="text-muted">Live external API data streaming synchronization logs, pest reporting matrix channels, and micro-optimization engines.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            
            <div class="card shadow-sm border-0 mb-4 bg-white">
                <div class="card-header bg-dark text-white py-3">
                    <h6 class="mb-0 font-monospace text-warning">📡 Live Weather Log API Synchronization</h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3 bg-light p-2 rounded">
                        <small class="fw-bold text-secondary font-monospace">SYNC LOG STATUS:</small>
                        <span class="badge {{ str_contains($syncStatus, 'SUCCESSFUL') ? 'bg-success' : 'bg-danger' }} font-monospace">
                            {{ $syncStatus }}
                        </span>
                    </div>

                    @if($weatherData)
                        <div class="row text-center mt-3 g-2">
                            <div class="col-6 border-end">
                                <span class="text-muted d-block small">Live Temperature Indicator</span>
                                <h2 class="fw-bold text-success mt-1">{{ $weatherData['temperature'] }}°C</h2>
                            </div>
                            <div class="col-6">
                                <span class="text-muted d-block small">Logged Wind Velocity Velocity</span>
                                <h2 class="fw-bold text-info mt-1">{{ $weatherData['windspeed'] }} km/h</h2>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning small mb-0">
                            The system is currently running on simulated offline crop metrics. Verify your server's internet connection.
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm border-0 bg-white">
                <div class="card-header bg-success text-white py-3">
                    <h6 class="mb-0 fw-bold">🌱 Dynamic Seed & Base Material Optimizer</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('utilities.seed') }}" method="POST">
                        @csrf
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Target Grain Variant</label>
                                <select name="target_crop" class="form-select" required>
                                    <option value="rice" {{ old('target_crop') == 'rice' ? 'selected' : '' }}>Paddy Rice (ধান)</option>
                                    <option value="wheat" {{ old('target_crop') == 'wheat' ? 'selected' : '' }}>Wheat Grain</option>
                                    <option value="maize" {{ old('target_crop') == 'maize' ? 'selected' : '' }}>Maize Corn</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Acreage Plot Dimensions</label>
                                <input type="number" step="0.01" name="area_size" class="form-control" placeholder="Acres" value="{{ old('area_size') }}" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm w-100 fw-bold">Calibrate Material Inputs</button>
                    </form>

                    @if(session('seed_results'))
                        <div class="mt-3 p-3 bg-light border-start border-3 border-success rounded small">
                            <span class="d-block text-success fw-bold mb-2">📊 Calculation Output Metrics:</span>
                            Target Variant: <strong>{{ session('seed_results')['crop'] }}</strong> across <strong>{{ session('seed_results')['acres'] }} Acres</strong>.<br>
                            • Optimized Seed Stock Mass: <span class="badge bg-dark">{{ session('seed_results')['required_seed_kg'] }} kg</span><br>
                            • Companion Nitrogen Target Base: <span class="badge bg-secondary">{{ session('seed_results')['suggested_urea_kg'] }} kg</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-header bg-danger text-white py-3">
                    <h6 class="mb-0 fw-bold">🪲 Bio-Hazard Pest & Crop Outbreak Reporting Form</h6>
                </div>
                <div class="card-body p-4">
                    @if(session('pest_success'))
                        <div class="alert alert-success small">{{ session('pest_success') }}</div>
                    @endif

                    <form action="{{ route('utilities.pest') }}" method="POST">
                        @csrf
                        <div class="row g-2 mb-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Impacted Crop</label>
                                <input type="text" name="crop_type" class="form-control form-control-sm" placeholder="e.g. Rice Pad" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Pest/Disease Name</label>
                                <input type="text" name="pest_name" class="form-control form-control-sm" placeholder="e.g. Stem Borer" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Outbreak Status</label>
                                <select name="severity" class="form-select form-select-sm" required>
                                    <option value="low">Low - Spreading Spores</option>
                                    <option value="medium">Medium - Visible Loss</option>
                                    <option value="critical">Critical - Total Plot Ruin</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Describe Physical Anomalies / Outbreak Patterns</label>
                            <textarea name="description" class="form-control form-control-sm" rows="3" placeholder="Provide leaf damage colors or activity details..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold">Transmit Hazard Warning Data</button>
                    </form>

                    <h6 class="fw-bold text-dark mt-4 mb-2 small border-bottom pb-1">📋 Active Bio-Hazard Pipeline Database Stream (Latest entries)</h6>
                    <div class="list-group list-group-flush">
                        @forelse($pastReports as $report)
                            <div class="list-group-item px-0 py-2 bg-transparent">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <strong class="text-dark small">{{ $report->pest_name }} on {{ $report->crop_type }}</strong>
                                    <span class="badge {{ $report->severity == 'critical' ? 'bg-danger' : ($report->severity == 'medium' ? 'bg-warning text-dark' : 'bg-secondary') }} rounded-pill font-monospace" style="font-size: 0.7rem;">
                                        {{ $report->severity }}
                                    </span>
                                </div>
                                <p class="text-muted mb-0 font-monospace text-truncate" style="font-size: 0.75rem;">{{ $report->description }}</p>
                                <small class="text-secondary block font-monospace" style="font-size: 0.65rem;">Logged by user ID: {{ $report->user_id }} at {{ $report->created_at->format('H:i') }}</small>
                            </div>
                        @empty
                            <p class="text-muted small text-center py-2 mb-0">No pest security threats logged into current cycle database.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection