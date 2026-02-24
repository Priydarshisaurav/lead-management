@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 mt-4">

    {{-- Filter Section --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body p-4">
            <form method="GET" action="" id="filterForm">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="search-box">
                            <i class="bi bi-search position-absolute ms-3 mt-3 text-muted"></i>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   class="form-control form-control-lg ps-5 rounded-pill border-0 bg-light"
                                   placeholder="Search by name or email...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill">
                            <i class="bi bi-funnel me-2"></i>Apply
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0 rounded-4 shadow-lg">
        <div class="card-header bg-transparent border-0 p-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">
                <i class="bi bi-table me-2 text-primary"></i>Sales Representatives
            </h4>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">#ID</th>
                            <th class="py-3">Sales Person</th>
                            <th class="py-3">Contact</th>
                            <th class="py-3">Role</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($salesUsers as $user)
                        <tr class="border-bottom">
                            <td class="ps-4">
                                <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                    #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3 bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center">
                                        <span class="fw-bold fs-6">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $user->name }}</h6>
                                        <small class="text-muted">Member since {{ $user->created_at->format('M Y') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span><i class="bi bi-envelope me-2 text-muted"></i>{{ $user->email }}</span>
                                    @if($user->phone)
                                        <small class="text-muted"><i class="bi bi-phone me-2"></i>{{ $user->phone }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                    <i class="bi bi-briefcase-fill me-1"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="py-3 text-end pe-4">
                                @if($user->role === 'sales')
                                <form action="{{ route('sales.toggle', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                        class="btn btn-sm rounded-pill {{ $user->is_active ? 'btn-success' : 'btn-danger' }}">
                                        {{ $user->is_active ? 'Active' : 'Deactive' }}
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-people display-1 text-muted"></i>
                                    <h4 class="mt-3">No Sales Person Found</h4>
                                    <p class="text-muted">Get started by adding your first sales representative</p>
                                    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addSalesPerson">
                                        <i class="bi bi-plus-circle me-2"></i>Add Sales Person
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<style>
.avatar-circle {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.search-box { position: relative; }
.search-box i { z-index: 10; }

.table tbody tr:hover { background-color: rgba(13, 110, 253, 0.02); }
.empty-state { padding: 3rem; text-align: center; }
</style>

@endsection
