<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                {{ __('Customer Profile') }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('customers.edit', $customer) }}" class="bg-indigo-600 text-white px-8 py-4 rounded-xl hover:bg-indigo-700 font-bold text-xl shadow-lg transition-all">
                    Edit Customer
                </a>
                <a href="{{ route('customers.index') }}" class="bg-gray-600 text-white px-8 py-4 rounded-xl hover:bg-gray-700 font-bold text-xl shadow-lg transition-all">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Customer Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                        <div class="p-6 sm:p-8">
                            <h3 class="text-2xl font-bold mb-6 text-gray-800 border-b-3 border-gray-300 pb-4">
                                Customer Information
                            </h3>

                            <div class="space-y-6">
                                <div>
                                    <div class="text-lg font-semibold text-gray-600 mb-2">Customer Code</div>
                                    <div class="text-2xl font-bold text-blue-600 bg-blue-50 px-5 py-4 rounded-xl border-2 border-blue-200">
                                        {{ $customer->customer_code }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-lg font-semibold text-gray-600 mb-2">Name</div>
                                    <div class="text-2xl font-bold text-gray-900">
                                        {{ $customer->name }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-lg font-semibold text-gray-600 mb-2">Email</div>
                                    <div class="text-xl text-gray-700">
                                        {{ $customer->email ?: 'Not provided' }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-lg font-semibold text-gray-600 mb-2">Phone</div>
                                    <div class="text-xl text-gray-700">
                                        {{ $customer->phone ?: 'Not provided' }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-lg font-semibold text-gray-600 mb-2">Address</div>
                                    <div class="text-xl text-gray-700 whitespace-pre-line">
                                        {{ $customer->address ?: 'Not provided' }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-lg font-semibold text-gray-600 mb-2">Member Since</div>
                                    <div class="text-xl text-gray-700">
                                        {{ $customer->created_at->format('F d, Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                            <div class="p-8">
                                <div class="text-xl font-semibold text-gray-600 mb-3">Total Purchases</div>
                                <div class="text-5xl font-bold text-blue-600">{{ $customer->sales->count() }}</div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                            <div class="p-8">
                                <div class="text-xl font-semibold text-gray-600 mb-3">Total Spent</div>
                                <div class="text-5xl font-bold text-green-600">
                                    ${{ number_format($customer->sales->sum('total'), 2) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sales History -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                        <div class="p-6 sm:p-8">
                            <h3 class="text-2xl font-bold mb-6 text-gray-800 border-b-3 border-gray-300 pb-4">
                                Purchase History
                            </h3>

                            @if($customer->sales->count() > 0)
                                <!-- Desktop Table -->
                                <div class="hidden md:block overflow-x-auto">
                                    <table class="min-w-full border-3 border-gray-300">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 border-b-3 border-gray-300">Invoice #</th>
                                                <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 border-b-3 border-gray-300">Date</th>
                                                <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 border-b-3 border-gray-300">Items</th>
                                                <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 border-b-3 border-gray-300">Total</th>
                                                <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 border-b-3 border-gray-300">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($customer->sales->sortByDesc('created_at') as $sale)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-6 py-5 border-b-2 border-gray-200 text-lg font-semibold text-gray-900">
                                                        {{ $sale->invoice_number }}
                                                    </td>
                                                    <td class="px-6 py-5 border-b-2 border-gray-200 text-lg text-gray-700">
                                                        {{ $sale->created_at->format('M d, Y h:i A') }}
                                                    </td>
                                                    <td class="px-6 py-5 border-b-2 border-gray-200 text-lg text-gray-700">
                                                        {{ $sale->saleItems->count() }} item(s)
                                                    </td>
                                                    <td class="px-6 py-5 border-b-2 border-gray-200 text-xl font-bold text-green-600">
                                                        ${{ number_format($sale->total, 2) }}
                                                    </td>
                                                    <td class="px-6 py-5 border-b-2 border-gray-200">
                                                        <a href="{{ route('sales.show', $sale) }}"
                                                           class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-bold text-lg shadow-md transition-all inline-block">
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Mobile Cards -->
                                <div class="md:hidden space-y-4">
                                    @foreach($customer->sales->sortByDesc('created_at') as $sale)
                                        <div class="border-3 border-gray-300 rounded-xl p-6 bg-gray-50 shadow-md">
                                            <div class="mb-4">
                                                <div class="text-sm font-semibold text-gray-600 mb-1">Invoice Number</div>
                                                <div class="text-xl font-bold text-gray-900">{{ $sale->invoice_number }}</div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="text-sm font-semibold text-gray-600 mb-1">Date</div>
                                                <div class="text-lg text-gray-700">{{ $sale->created_at->format('M d, Y h:i A') }}</div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="text-sm font-semibold text-gray-600 mb-1">Items</div>
                                                <div class="text-lg text-gray-700">{{ $sale->saleItems->count() }} item(s)</div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="text-sm font-semibold text-gray-600 mb-1">Total</div>
                                                <div class="text-2xl font-bold text-green-600">${{ number_format($sale->total, 2) }}</div>
                                            </div>
                                            <a href="{{ route('sales.show', $sale) }}"
                                               class="block w-full bg-blue-600 text-white px-6 py-4 rounded-xl hover:bg-blue-700 font-bold text-xl text-center shadow-md transition-all">
                                                View Sale
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-10">
                                    <div class="text-6xl mb-4">📊</div>
                                    <p class="text-2xl text-gray-500 mb-6">No purchase history yet</p>
                                    <p class="text-xl text-gray-600">This customer hasn't made any purchases.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
