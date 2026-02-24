@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <h1 class="text-3xl font-bold text-gray-800 mb-8">
        Dashboard Overview
    </h1>

    {{-- ================= SUMMARY CARDS ================= --}}
   <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

    {{-- Total Leads --}}
    <div class="bg-white shadow rounded-2xl p-6 border-l-4 border-blue-500">
        <p class="text-gray-500 text-sm">Total Leads</p>
        <h2 class="text-2xl font-bold text-gray-800 mt-2">
            {{ $totalLeads }}
        </h2>
    </div>

    {{-- Expected Value --}}
    <div class="bg-white shadow rounded-2xl p-6 border-l-4 border-purple-500">
        <p class="text-gray-500 text-sm">Expected Value</p>
        <h2 class="text-2xl font-bold text-gray-800 mt-2">
            ₹ {{ number_format($expectedValue ?? 0, 2) }}
        </h2>
    </div>

    {{-- Won Value --}}
    <div class="bg-white shadow rounded-2xl p-6 border-l-4 border-green-500">
        <p class="text-gray-500 text-sm">Won Value</p>
        <h2 class="text-2xl font-bold text-gray-800 mt-2">
            ₹ {{ number_format($wonValue ?? 0, 2) }}
        </h2>
    </div>

    {{-- Conversion Rate --}}
    @php
        $wonCount = $stageCounts->where('stage','Won')->first()?->total ?? 0;
        $rate = $totalLeads > 0 ? round(($wonCount / $totalLeads) * 100, 2) : 0;
    @endphp
    <div class="bg-white shadow rounded-2xl p-6 border-l-4 border-orange-500">
        <p class="text-gray-500 text-sm">Conversion Rate</p>
        <h2 class="text-2xl font-bold text-gray-800 mt-2">
            {{ $rate }}%
        </h2>
    </div>

</div>



    {{-- ================= FILTER SECTION ================= --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-10">
        <form method="GET" class="flex flex-wrap gap-4 items-end">

            {{-- Stage Filter --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Filter by Stage
                </label>
                <select name="stage" class="border-gray-300 rounded-lg shadow-sm">
                    <option value="">All Stages</option>
                    @foreach(\App\Models\Lead::stages() as $stage)
                    <option value="{{ $stage }}" {{ request('stage')==$stage ? 'selected' : '' }}>
                        {{ $stage }}
                    </option>
                    @endforeach

                </select>
            </div>

            {{-- Admin User Filter --}}
            @if(auth()->user()->role === 'admin')
            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Assigned User
                </label>
                <select name="assigned_to" class="border-gray-300 rounded-lg shadow-sm">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('assigned_to')==$user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif

            <button class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                Apply
            </button>

        </form>
    </div>


    {{-- ================= LEADS PER STAGE ================= --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-10">
        <h3 class="text-lg font-semibold mb-4">
            Leads Per Stage
        </h3>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($stageCounts as $stage)
            <div class="bg-gray-50 rounded-xl p-4 text-center">
                <p class="text-sm text-gray-500">
                    {{ $stage->stage }}
                </p>
                <p class="text-2xl font-bold text-gray-800 mt-1">
                    {{ $stage->total }}
                </p>
            </div>
            @endforeach
        </div>
    </div>


    {{-- ================= LEADS TABLE ================= --}}
 

</div>
@endsection


<!-- Recent Leads -->
{{-- <div class="bg-white rounded-2xl shadow p-6">
    <h3 class="text-lg font-semibold mb-4">
        Recent Leads
    </h3>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Name</th>
                    <th>Company</th>
                    <th>Stage</th>
                    <th>Expected</th>
                    <th>Assigned</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Lead::latest()->take(10)->get() as $lead)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $lead->name }}</td>
                    <td>{{ $lead->company_name }}</td>
                    <td>
                        <span class="px-3 py-1 rounded-full text-xs
                                @if($lead->stage=='Won') bg-green-100 text-green-700
                                @elseif($lead->stage=='Lost') bg-red-100 text-red-700
                                @else bg-blue-100 text-blue-700
                                @endif">
                            {{ $lead->stage }}
                        </span>
                    </td>
                    <td>₹ {{ number_format($lead->expected_value ?? 0,2) }}</td>
                    <td>{{ $lead->assignedUser?->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div> --}}