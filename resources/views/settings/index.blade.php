<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Company Information</h3>

                            <div class="mb-4">
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Name
                                </label>
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $settings['company_name']) }}" class="w-full px-3 py-2 border rounded-lg">
                                @error('company_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="company_address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Address
                                </label>
                                <textarea name="company_address" id="company_address" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('company_address', $settings['company_address']) }}</textarea>
                                @error('company_address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="company_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Phone
                                </label>
                                <input type="text" name="company_phone" id="company_phone" value="{{ old('company_phone', $settings['company_phone']) }}" class="w-full px-3 py-2 border rounded-lg">
                                @error('company_phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="company_email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Email
                                </label>
                                <input type="email" name="company_email" id="company_email" value="{{ old('company_email', $settings['company_email']) }}" class="w-full px-3 py-2 border rounded-lg">
                                @error('company_email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Invoice Configuration</h3>

                            <div class="mb-4">
                                <label for="invoice_header" class="block text-sm font-medium text-gray-700 mb-2">
                                    Invoice Header
                                    <span class="text-sm text-gray-500">(Displayed at the top of invoices)</span>
                                </label>
                                <textarea name="invoice_header" id="invoice_header" rows="4" class="w-full px-3 py-2 border rounded-lg">{{ old('invoice_header', $settings['invoice_header']) }}</textarea>
                                @error('invoice_header')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="invoice_footer" class="block text-sm font-medium text-gray-700 mb-2">
                                    Invoice Footer
                                    <span class="text-sm text-gray-500">(Displayed at the bottom of invoices)</span>
                                </label>
                                <textarea name="invoice_footer" id="invoice_footer" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('invoice_footer', $settings['invoice_footer']) }}</textarea>
                                @error('invoice_footer')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tax_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                    Default Tax Rate (%)
                                </label>
                                <input type="number" name="tax_rate" id="tax_rate" value="{{ old('tax_rate', $settings['tax_rate']) }}" step="0.01" min="0" max="100" class="w-full px-3 py-2 border rounded-lg">
                                @error('tax_rate')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
