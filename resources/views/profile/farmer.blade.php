@extends('layouts.app')

@section('title', 'My Farmer Profile - Krshi Bondhu')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 text-center p-4">
                <div class="my-3">
                    @if($profile->profile_image)
                        <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="Farmer Profile Image" class="rounded-circle img-thumbnail shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-light d-inline-block rounded-circle p-4 border shadow-sm" style="width: 120px; height: 120px;">
                            <span class="fs-1">🧑‍🌾</span>
                        </div>
                    @endif
                </div>
                <h4 class="fw-bold text-success mb-1">{{ $user->name }}</h4>
                <p class="badge bg-success px-3 py-2 rounded-pill mb-3">Verified Farmer</p>
                <hr>
                <div class="text-start small text-muted">
                    <p class="mb-2"><strong>📧 Registered Email:</strong><br>{{ $user->email }}</p>
                    <p class="mb-0"><strong>📞 Registered Phone:</strong><br>{{ $user->phone }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 text-success fw-bold">⚙️ Manage Farming Telemetry Profile</h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.farmer.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">Display Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">Primary Contact Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="profile_image" class="form-label fw-bold">Upload / Update Profile Photo</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                            <div class="form-text small text-muted">Supported form extensions: JPG, JPEG, PNG, GIF. Max file cap limit: 2MB.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="farm_location" class="form-label fw-bold">Farm Geographic Location</label>
                                <input type="text" class="form-control" id="farm_location" name="farm_location" placeholder="e.g. Jessore, Khulna" value="{{ old('farm_location', $profile->farm_location) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="crop_type" class="form-label fw-bold">Primary Crop Specialization</label>
                                <input type="text" class="form-control" id="crop_type" name="crop_type" placeholder="e.g. Aman Rice, Potato" value="{{ old('crop_type', $profile->crop_type) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="land_size" class="form-label fw-bold">Total Land Holdings Size (Acres/Bighas)</label>
                            <input type="number" step="0.01" class="form-control" id="land_size" name="land_size" placeholder="e.g. 2.50" value="{{ old('land_size', $profile->land_size) }}">
                        </div>

                        <div class="mb-3">
                            <label for="contact_details" class="form-label fw-bold">Detailed Delivery/Contact Address</label>
                            <textarea class="form-control" id="contact_details" name="contact_details" rows="2" placeholder="Full address for buyers to find you">{{ old('contact_details', $profile->contact_details) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="farming_history" class="form-label fw-bold">Farming Experience & History Notes</label>
                            <textarea class="form-control" id="farming_history" name="farming_history" rows="3" placeholder="Describe your experience or current setups">{{ old('farming_history', $profile->farming_history) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success fw-bold px-5 py-2 mt-2">Save Profile Updates</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection