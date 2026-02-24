@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-file-text-fill me-2"></i>Quotations Management
        </h2>

        <a href="{{ route('quotations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Create New Quotation
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Lead Name</th>
                            <th>Product</th>
                            <th>Total Amount</th>
                            <th>Valid Till</th>
                            <th>Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($quotations as $quotation)
                        <tr>
                            <td>{{ $quotation->id }}</td>

                            <td>
                                {{ $quotation->lead->name ?? 'N/A' }}
                            </td>

                            <td>{{ $quotation->product_name }}</td>

                            <td>
                                ₹{{ number_format($quotation->total_amount, 2) }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($quotation->valid_till)->format('d M Y') }}
                            </td>

                            <!-- ✅ STATUS DROPDOWN -->
                            <td>
                                <form action="{{ route('quotations.updateStatus', $quotation->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <select name="status"
                                            class="form-select form-select-sm"
                                            onchange="this.form.submit()">

                                        <option value="Draft"
                                            {{ $quotation->status == 'Draft' ? 'selected' : '' }}>
                                            Draft
                                        </option>

                                        <option value="Accepted"
                                            {{ $quotation->status == 'Accepted' ? 'selected' : '' }}>
                                            Accepted
                                        </option>

                                        <option value="Rejected"
                                            {{ $quotation->status == 'Rejected' ? 'selected' : '' }}>
                                            Rejected
                                        </option>

                                    </select>
                                </form>
                            </td>

                            <td>
                                <a href="{{ route('quotations.show', $quotation->id) }}"
                                   class="btn btn-sm btn-info">
                                    View
                                </a>

                                <a href="{{ route('invoice.download', $quotation->id) }}"
                                   class="btn btn-sm btn-success">
                                    PDF
                                </a>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No quotations found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $quotations->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
