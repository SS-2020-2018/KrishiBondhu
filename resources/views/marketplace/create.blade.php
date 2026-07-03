@extends('layouts.app')

@section('title', 'List Equipment - Krshi Bondhu')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0 fw-bold">🚜 Post Machinery Item Advertisement</h5>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('marketplace.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">Equipment/Tool Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Power Tiller, Diesel Water Pump" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="listing_type" class="form-label fw-bold">Listing Intent</label>
                                <select class="form-select" id="listing_type" name="listing_type" required>
                                    <option value="sell">Sell - General Handover Ownership</option>
                                    <option value="rent">Rent - Temporary Operation Contracts</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-bold">Target Valuation Price (BDT)</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Rate or final sales point" value="{{ old('price') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label fw-bold">Available Quantity Units</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="1" min="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label fw-bold">Geographic Storage Location</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="e.g. Sadar Upazila, Jessore" value="{{ old('location') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="product_image" class="form-label fw-bold">Equipment Illustration Image File</label>
                            <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*">
                            <div class="form-text small text-muted">Upload high-resolution capture frames for better sales conversions. Max 2MB limit.</div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Comprehensive Specifications & Tool Conditions</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Detail horse-power, brand, previous usages variables or terms of delivery..." required>{{ old('description') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('marketplace.index') }}" class="btn btn-light px-4 fw-bold">Cancel</a>
                            <button type="submit" class="btn btn-success px-5 fw-bold">Publish Listing Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection