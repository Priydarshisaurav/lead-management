@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto">

        <!-- Card -->
        <div class="bg-white shadow-xl rounded-2xl p-8">

            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-3">
                ➕ Add New Lead
            </h2>

            <form method="POST" action="{{ route('leads.store') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Name
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Company Name
                    </label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}"
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Phone
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- Source -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Lead Source
                    </label>
                    <select name="source"
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Select Source</option>
                        <option value="Instagram">Instagram</option>
                        <option value="Website">Website</option>
                        <option value="Reference">Reference</option>
                        <option value="Cold Call">Cold Call</option>
                    </select>
                </div>

                <!-- Button -->
                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="bg-blue-600 hover: rounded-lg shadow-md transition duration-200">
                        💾 Save Lead
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
