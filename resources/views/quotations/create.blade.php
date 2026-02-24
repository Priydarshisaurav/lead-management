<!-- resources/views/quotations/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-0">
                <i class="bi bi-plus-circle-fill me-2"></i>Create New Quotation
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-2">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('quotations.index') }}">Quotations</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('quotations.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Create Form -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('quotations.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-8">
                        <!-- Lead Selection -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Select Lead <span class="text-danger">*</span></label>
                            <select class="form-select @error('lead_id') is-invalid @enderror" name="lead_id" required>
                                <option value="">Choose Lead...</option>
                                @foreach($leads as $lead)
                                    <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id ? 'selected' : '' }}>
                                        {{ $lead->name }} - {{ $lead->company }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lead_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Item Details Card -->
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Item Details</h6>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Item/Product Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('product_name') is-invalid @enderror" 
                                               name="product_name" value="{{ old('product_name') }}" required>
                                        @error('product_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                               name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Rate (₹) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('rate') is-invalid @enderror" 
                                               name="rate" value="{{ old('rate') }}" min="0" step="0.01" required>
                                        @error('rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">GST Percentage <span class="text-danger">*</span></label>
                                        <select class="form-select @error('gst_percentage') is-invalid @enderror" 
                                                name="gst_percentage" required>
                                            <option value="">Select GST</option>
                                            <option value="0" {{ old('gst_percentage') == 0 ? 'selected' : '' }}>0%</option>
                                            <option value="5" {{ old('gst_percentage') == 5 ? 'selected' : '' }}>5%</option>
                                            <option value="12" {{ old('gst_percentage') == 12 ? 'selected' : '' }}>12%</option>
                                            <option value="18" {{ old('gst_percentage') == 18 ? 'selected' : '' }}>18%</option>
                                            <option value="28" {{ old('gst_percentage') == 28 ? 'selected' : '' }}>28%</option>
                                        </select>
                                        @error('gst_percentage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Description (Optional)</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  name="description" rows="2">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Summary -->
                    <div class="col-md-4">
                        <!-- Quotation Settings -->
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Quotation Details</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label">Valid Till <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('valid_till') is-invalid @enderror" 
                                           name="valid_till" value="{{ old('valid_till', date('Y-m-d', strtotime('+30 days'))) }}" required>
                                    @error('valid_till')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Terms & Conditions</label>
                                    <textarea class="form-control @error('terms') is-invalid @enderror" 
                                              name="terms" rows="3">{{ old('terms', "1. Quotation valid for 30 days\n2. GST extra as applicable") }}</textarea>
                                    @error('terms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Price Summary -->
                        <div class="card bg-primary text-white border-0 mb-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Price Summary</h6>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span class="fw-bold" id="subtotal">₹0.00</span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span>GST Amount:</span>
                                    <span class="fw-bold" id="gstAmount">₹0.00</span>
                                </div>
                                
                                <hr class="bg-white opacity-25">
                                
                                <div class="d-flex justify-content-between">
                                    <span class="h5 mb-0">Total:</span>
                                    <span class="h5 mb-0 fw-bold" id="total">₹0.00</span>
                                </div>

                                <!-- Hidden fields for calculated values -->
                                <input type="hidden" name="subtotal" id="subtotal_input" value="0">
                                <input type="hidden" name="gst_amount" id="gst_amount_input" value="0">
                                <input type="hidden" name="total_amount" id="total_amount_input" value="0">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-check-circle me-2"></i>Create Quotation
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function calculateTotal() {
    let quantity = parseFloat(document.querySelector('input[name="quantity"]').value) || 0;
    let rate = parseFloat(document.querySelector('input[name="rate"]').value) || 0;
    let gstPercentage = parseFloat(document.querySelector('select[name="gst_percentage"]').value) || 0;

    let subtotal = quantity * rate;
    let gstAmount = (subtotal * gstPercentage) / 100;
    let total = subtotal + gstAmount;

    document.getElementById('subtotal').textContent = '₹' + subtotal.toFixed(2);
    document.getElementById('gstAmount').textContent = '₹' + gstAmount.toFixed(2);
    document.getElementById('total').textContent = '₹' + total.toFixed(2);

    document.getElementById('subtotal_input').value = subtotal.toFixed(2);
    document.getElementById('gst_amount_input').value = gstAmount.toFixed(2);
    document.getElementById('total_amount_input').value = total.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    calculateTotal(); // initial calculation if old values exist

    // Instant update
    const inputs = document.querySelectorAll('input[name="quantity"], input[name="rate"]');
    const select = document.querySelector('select[name="gst_percentage"]');

    inputs.forEach(input => input.addEventListener('input', calculateTotal));
    select.addEventListener('change', calculateTotal);
});
</script>
@endpush

@endsection
