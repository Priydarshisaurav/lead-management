    @extends('layouts.app')

    @section('content')
    <div class="container-fluid px-4">

        <div class="row">
            <div class="col-lg-10 mx-auto">

                <div class="card border-0 shadow-sm rounded-4">

                    <!-- Header Section -->
                    <div class="card-body border-bottom d-flex align-items-center justify-content-between">

                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                style="width:70px; height:70px;">
                                <i class="bi bi-person-fill fs-2 text-secondary"></i>
                            </div>

                            <div>
                                <h5 class="mb-1 fw-semibold">{{ auth()->user()->name }}</h5>
                                <div class="text-muted small">
                                    {{ auth()->user()->email }}
                                </div>
                                <span class="badge bg-secondary mt-1 text-capitalize">
                                    {{ auth()->user()->role ?? 'User' }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            <i class="bi bi-pencil-square"></i> Edit Profile
                        </a>

                    </div>


                    <!-- Information Section -->
                    <div class="card-body">

                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="text-muted small">Full Name</label>
                                <div class="fw-medium">
                                    {{ auth()->user()->name }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Email Address</label>
                                <div class="fw-medium">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Role</label>
                                <div class="fw-medium text-capitalize">
                                    {{ auth()->user()->role ?? 'User' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Member Since</label>
                                <div class="fw-medium">
                                    {{ auth()->user()->created_at->format('F d, Y') }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Account Status</label>
                                <div>
                                    <span class="badge bg-success">Active</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Last Login</label>
                                <div class="fw-medium">
                                    {{ now()->format('F d, Y - h:i A') }}
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Footer Section -->
                    <div class="card-footer bg-white border-0 text-end">
                        <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill px-4">
                            <i class="bi bi-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>

                </div>

            </div>
        </div>

    </div>
    @endsection
