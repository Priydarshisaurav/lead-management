@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Leads Management
        </h2>

        <a href="{{ route('leads.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
            + Add Lead
        </a>
    </div>

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>

    @endif

    @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Filter --}}
    {{-- Filter --}}
<div class="bg-white p-4 rounded-xl shadow mb-6">
    <form method="GET" class="flex flex-wrap gap-4 items-end">

        {{-- Stage Filter --}}
        <div>
            <label class="block text-sm text-gray-600 mb-1">
                Filter by Stage
            </label>
            <select name="stage" class="border rounded-lg px-3 py-2 w-52">
                <option value="">All Stages</option>
                @foreach(\App\Services\LeadStageService::$stages as $stage)
                    <option value="{{ $stage }}"
                        {{ request('stage') == $stage ? 'selected' : '' }}>
                        {{ $stage }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- ✅ Assigned User Filter (Admin Only) --}}
        @if(auth()->user()->isAdmin())
        <div>
            <label class="block text-sm text-gray-600 mb-1">
                Filter by Assigned User
            </label>
            <select name="assigned_to" class="border rounded-lg px-3 py-2 w-52">
                <option value="">All Users</option>
                @foreach($salesUsers as $user)
                    <option value="{{ $user->id }}"
                        {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        <div>
            <button class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2 rounded-lg">
                Apply Filter
            </button>
        </div>

    </form>
</div>


    {{-- Leads Table --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-left">
            <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                <tr>
                    <th class="p-4">Name</th>
                    <th>Company</th>
                    <th>Stage</th>
                    <th>Assigned To</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($leads as $lead)
                <tr class="hover:bg-gray-50 transition">

                    <td class="p-4 font-medium text-gray-800">
                        {{ $lead->name }}
                    </td>

                    <td>{{ $lead->company_name }}</td>

                    {{-- Stage Badge --}}
                    <td>
                        <span class="px-3 py-1 text-sm rounded-full
                            @if($lead->stage=='Won') bg-green-100 text-green-700
                            @elseif($lead->stage=='Lost') bg-red-100 text-red-700
                            @elseif($lead->stage=='Negotiation') bg-yellow-100 text-yellow-700
                            @else bg-blue-100 text-blue-700
                            @endif">
                            {{ $lead->stage }}
                        </span>
                    </td>

                    <td>
                        {{ $lead->assignedUser?->name ?? 'Not Assigned' }}
                    </td>

                    {{-- Actions --}}
                    <td class="text-center space-x-3">

                        <a href="{{ route('leads.show',$lead) }}"
                           class="text-blue-600 hover:underline">
                            View
                        </a>

                        {{-- Move Stage Form --}}
                        <form action="{{ route('leads.moveStage',$lead) }}"
                              method="POST"
                              class="inline space-x-2">

                            @csrf

                            @php
                                $allStages = \App\Services\LeadStageService::$stages;
                                $currentIndex = array_search($lead->stage, $allStages);
                                $nextStage = $allStages[$currentIndex + 1] ?? null;
                            @endphp

                            {{-- Only allow move if not final --}}
                            @if($lead->stage !== 'Won' && $lead->stage !== 'Lost')

                                <select name="stage"
                                        class="border rounded px-2 py-1 text-sm stage-select">
                                    
                                    @if($nextStage)
                                        <option value="{{ $nextStage }}">
                                            {{ $nextStage }}
                                        </option>
                                    @endif

                                    <option value="Lost">Lost</option>

                                </select>

                                {{-- Lost Reason --}}
                                <textarea name="lost_reason"
                                          placeholder="Enter lost reason"
                                          class="border rounded px-2 py-1 text-sm hidden lost-reason"
                                          rows="1"></textarea>

                                {{-- Admin assign --}}
                                @if(auth()->user()->isAdmin())
                                    <select name="assigned_to"
                                            class="border rounded px-2 py-1 text-sm">
                                        <option value="">Assign Sales</option>
                                        @foreach($salesUsers as $user)
                                            <option value="{{ $user->id }}"
                                                {{ $lead->assigned_to == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif

                                <button class="text-green-600 hover:underline">
                                    Move
                                </button>

                            @endif
                        </form>

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5"
                        class="text-center py-6 text-gray-500">
                        No leads found.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>

    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $leads->links() }}
    </div>

</div>

{{-- JS for Lost Reason Toggle --}}
<script>
document.addEventListener("change", function(e) {
    if (e.target.classList.contains("stage-select")) {

        let form = e.target.closest("form");
        let textarea = form.querySelector(".lost-reason");

        if (e.target.value === "Lost") {
            textarea.classList.remove("hidden");
        } else {
            textarea.classList.add("hidden");
            textarea.value = '';
        }
    }
});
</script>

@endsection
