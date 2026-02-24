@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-8">

    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-bold mb-6">
            {{ $lead->name }} - Lead Stage Flow
        </h2>

        <p><strong>Company:</strong> {{ $lead->company_name }}</p>
        <p><strong>Assigned To:</strong> {{ $lead->assignedUser?->name ?? 'Not Assigned' }}</p>

        @if($lead->stage === 'Lost')
            <p class="mt-2 text-red-600 font-semibold">
                Lost Reason: {{ $lead->lost_reason }}
            </p>
        @endif

        {{-- Dynamic Stage Flow --}}
        <div class="overflow-x-auto mt-8">
            <div class="flex items-center space-x-10">

                @php
                    $allStages = \App\Services\LeadStageService::$stages;

                    // Hide Won if Lost
                    if ($lead->stage === 'Lost') {
                        $stages = array_diff($allStages, ['Won']);
                    }
                    // Hide Lost if Won
                    elseif ($lead->stage === 'Won') {
                        $stages = array_diff($allStages, ['Lost']);
                    }
                    else {
                        $stages = array_diff($allStages, ['Lost']);
                    }

                    $stages = array_values($stages);
                    $currentIndex = array_search($lead->stage, $stages);
                @endphp

                @foreach($stages as $index => $stage)

                    <div class="flex flex-col items-center relative">

                        {{-- Connecting Line --}}
                        @if($index != 0)
                            <div class="absolute -left-10 top-8 w-10 h-1
                                {{ $index <= $currentIndex ? 'bg-green-500' : 'bg-gray-300' }}">
                            </div>
                        @endif

                        {{-- Stage Circle --}}
                        <div class="w-16 h-16 flex items-center justify-center
                            rounded-full border-4
                            @if($index < $currentIndex)
                                border-green-500 bg-green-100 text-green-700
                            @elseif($index == $currentIndex)
                                border-blue-500 bg-blue-100 text-blue-700
                            @else
                                border-gray-300 bg-gray-100 text-gray-500
                            @endif
                            shadow">

                            <span class="font-bold">
                                {{ $index + 1 }}
                            </span>
                        </div>

                        {{-- Stage Label --}}
                        <span class="mt-3 text-center w-28 text-sm
                            @if($index < $currentIndex)
                                text-green-700 font-semibold
                            @elseif($index == $currentIndex)
                                text-blue-600 font-bold
                            @else
                                text-gray-500
                            @endif">
                            {{ $stage }}
                        </span>

                    </div>

                @endforeach

            </div>
        </div>

    </div>

    <div class="mt-6">
        <a href="{{ route('leads.index') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
            Back to Leads
        </a>
    </div>

</div>

@endsection
