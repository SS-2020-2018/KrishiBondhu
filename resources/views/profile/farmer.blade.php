@extends('layouts.app')

@section('title', 'My Dashboard - Krshi Bondhu')

@section('content')
<div class="container my-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card kb-profile-card h-100 text-center p-4">
                <div class="my-3">
                    @if($profileImage)
                        <img src="{{ asset('storage/' . $profileImage) }}" alt="User Profile Image" class="rounded-circle img-thumbnail shadow-sm" style="width: 156px; height: 156px; object-fit: cover;">
                    @else
                        <div class="bg-light d-inline-flex align-items-center justify-content-center rounded-circle border shadow-sm" style="width: 156px; height: 156px;">
                            <span class="fs-1">🧑</span>
                        </div>
                    @endif
                </div>

                <h4 class="fw-bold text-success mb-1">{{ $user->name ?? 'null' }}</h4>
                <p class="badge bg-success px-3 py-2 rounded-pill mb-3 text-uppercase">{{ ucfirst($user->role ?? 'null') }}</p>

                <div class="list-group text-start kb-profile-list">
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <span class="text-muted">Email</span>
                        <span class="fw-semibold">{{ $user->email ?? 'null' }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <span class="text-muted">Phone</span>
                        <span class="fw-semibold">{{ $user->phone ?? 'null' }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <span class="text-muted">Farm Location</span>
                        <span class="fw-semibold">{{ $profile?->farm_location ?? 'null' }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <span class="text-muted">Crop Type</span>
                        <span class="fw-semibold">{{ $profile?->crop_type ?? 'null' }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <span class="text-muted">Land Size</span>
                        <span class="fw-semibold">{{ $profile?->land_size ?? 'null' }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <span class="text-muted">Contact Details</span>
                        <span class="fw-semibold text-end">{{ $profile?->contact_details ?? 'null' }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <span class="text-muted">Farming History</span>
                        <span class="fw-semibold text-end">{{ $profile?->farming_history ?? 'null' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card kb-form-card">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 text-success fw-bold">Update Profile</h5>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('dashboard.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">Display Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Email Address</label>
                                <input type="email" class="form-control bg-light" id="email" value="{{ $user->email }}" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label fw-bold">Role</label>
                                <input type="text" class="form-control bg-light text-capitalize" id="role" value="{{ $user->role }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="profile_image" class="form-label fw-bold">Profile Photo</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                            <div class="form-text small text-muted">Saved in storage/app/public/profile and shown in the navigation bar when available.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="farm_location" class="form-label fw-bold">Farm Geographic Location</label>
                                <input type="text" class="form-control" id="farm_location" name="farm_location" placeholder="e.g. Jessore, Khulna" value="{{ old('farm_location', $profile?->farm_location) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="crop_type" class="form-label fw-bold">Primary Crop Specialization</label>
                                <input type="text" class="form-control" id="crop_type" name="crop_type" placeholder="e.g. Aman Rice, Potato" value="{{ old('crop_type', $profile?->crop_type) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="land_size" class="form-label fw-bold">Total Land Holdings Size</label>
                            <input type="number" step="0.01" class="form-control" id="land_size" name="land_size" placeholder="e.g. 2.50" value="{{ old('land_size', $profile?->land_size) }}">
                        </div>

                        <div class="mb-3">
                            <label for="contact_details" class="form-label fw-bold">Detailed Contact Address</label>
                            <textarea class="form-control" id="contact_details" name="contact_details" rows="2" placeholder="Full address for users to reach you">{{ old('contact_details', $profile?->contact_details) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="farming_history" class="form-label fw-bold">Farming Experience & History Notes</label>
                            <textarea class="form-control" id="farming_history" name="farming_history" rows="3" placeholder="Describe your experience or current setups">{{ old('farming_history', $profile?->farming_history) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success fw-bold px-5 py-2">Update Profile</button>
                        </div>
                    </form>
        </div>
    </div>
</div>
@endsection