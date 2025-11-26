<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                {{ __('Edit Customer') }}
            </h2>
            <a href="{{ route('customers.index') }}" class="bg-gray-600 text-white px-8 py-4 rounded-xl hover:bg-gray-700 font-bold text-xl shadow-lg transition-all">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('customers.update', $customer) }}">
                        @csrf
                        @method('PUT')

                        <!-- Customer Code Display (Read-only) -->
                        <div class="mb-8 bg-gray-100 border-3 border-gray-300 rounded-xl p-6">
                            <label class="block text-xl font-bold mb-3 text-gray-700">
                                Customer Code
                            </label>
                            <div class="text-3xl font-bold text-gray-900">
                                {{ $customer->customer_code }}
                            </div>
                        </div>

                        <!-- Name Field -->
                        <div class="mb-6">
                            <label for="name" class="block text-xl font-bold mb-3 text-gray-700">
                                Customer Name <span class="text-red-600">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name', $customer->name) }}"
                                   required
                                   class="w-full px-6 py-5 text-2xl border-3 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                   placeholder="Enter customer name">
                            @error('name')
                                <p class="text-red-600 text-lg mt-2 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-6">
                            <label for="email" class="block text-xl font-bold mb-3 text-gray-700">
                                Email Address
                            </label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   value="{{ old('email', $customer->email) }}"
                                   class="w-full px-6 py-5 text-2xl border-3 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                   placeholder="customer@example.com">
                            @error('email')
                                <p class="text-red-600 text-lg mt-2 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Field -->
                        <div class="mb-6">
                            <label for="phone" class="block text-xl font-bold mb-3 text-gray-700">
                                Phone Number
                            </label>
                            <input type="text"
                                   name="phone"
                                   id="phone"
                                   value="{{ old('phone', $customer->phone) }}"
                                   class="w-full px-6 py-5 text-2xl border-3 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                                   placeholder="Enter phone number">
                            @error('phone')
                                <p class="text-red-600 text-lg mt-2 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address Field -->
                        <div class="mb-8">
                            <label for="address" class="block text-xl font-bold mb-3 text-gray-700">
                                Address
                            </label>
                            <textarea name="address"
                                      id="address"
                                      rows="5"
                                      class="w-full px-6 py-5 text-2xl border-3 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500 @error('address') border-red-500 @enderror"
                                      placeholder="Enter full address">{{ old('address', $customer->address) }}</textarea>
                            @error('address')
                                <p class="text-red-600 text-lg mt-2 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="submit"
                                    class="flex-1 bg-green-600 text-white px-8 py-6 rounded-xl hover:bg-green-700 font-bold text-2xl shadow-lg transition-all">
                                Update Customer
                            </button>
                            <a href="{{ route('customers.index') }}"
                               class="flex-1 bg-gray-600 text-white px-8 py-6 rounded-xl hover:bg-gray-700 font-bold text-2xl text-center shadow-lg transition-all">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
