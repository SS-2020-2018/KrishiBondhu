@extends('layouts.app')

@section('title', 'Join Krshi Bondhu - Create Account')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0">🌾 Create Your Account</h4>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label fw-bold">Register As</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="farmer" {{ old('role') == 'farmer' ? 'selected' : '' }}>Farmer (কৃষক)</option>
                                <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>Agri-Equipment Seller</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold py-2 mt-2">Register Now</button>
                    </form>
                    <div class="text-center mt-3">
                        <p class="small text-muted mb-0">Already registered? <a href="{{ route('login') }}" class="text-success fw-bold">Log In Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection