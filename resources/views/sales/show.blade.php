<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                {{ __('Sale Details') }}
            </h2>
            <a href="{{ route('sales.index') }}" class="bg-gray-600 text-white px-8 py-4 rounded-xl hover:bg-gray-700 font-bold text-xl shadow-lg transition-all">
                Back to Sales
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                <div class="p-6 sm:p-8">
                    <!-- Sale Header -->
                    <div class="border-b-4 border-gray-300 pb-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="text-xl font-semibold text-gray-600 mb-2">Invoice Number</div>
                                <div class="text-4xl font-bold text-blue-600 mb-5">{{ $sale->invoice_number }}</div>

                                <div class="text-xl font-semibold text-gray-600 mb-2">Date & Time</div>
                                <div class="text-2xl text-gray-800 mb-5">{{ $sale->created_at->format('Y-m-d H:i:s') }}</div>
                            </div>
                            <div>
                                <div class="text-xl font-semibold text-gray-600 mb-2">Customer</div>
                                <div class="text-2xl text-gray-800 mb-5">
                                    {{ $sale->customer ? $sale->customer->name : 'Walk-in Customer' }}
                                    @if($sale->customer && $sale->customer->customer_code)
                                        <div class="text-lg text-gray-600 mt-1">Code: {{ $sale->customer->customer_code }}</div>
                                    @endif
                                </div>

                                <div class="text-xl font-semibold text-gray-600 mb-2">Cashier</div>
                                <div class="text-2xl text-gray-800">{{ $sale->user->name }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Line Items Table -->
                    <div class="mb-6">
                        <h3 class="text-2xl sm:text-3xl font-bold mb-5 text-gray-800">Items Purchased</h3>

                        <!-- Desktop Table -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y-2 divide-gray-200 border-2 border-gray-300 rounded-lg">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xl font-bold text-gray-800 uppercase tracking-wider">#</th>
                                        <th class="px-6 py-4 text-left text-xl font-bold text-gray-800 uppercase tracking-wider">Product</th>
                                        <th class="px-6 py-4 text-right text-xl font-bold text-gray-800 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-4 text-right text-xl font-bold text-gray-800 uppercase tracking-wider">Unit Price</th>
                                        <th class="px-6 py-4 text-right text-xl font-bold text-gray-800 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y-2 divide-gray-200">
                                    @foreach($sale->saleItems as $index => $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-xl text-gray-800">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 text-xl font-semibold text-gray-800">{{ $item->product->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xl text-gray-800 text-right">{{ $item->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xl text-gray-800 text-right">${{ number_format($item->price, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xl font-bold text-gray-800 text-right">${{ number_format($item->subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Cards -->
                        <div class="md:hidden space-y-4">
                            @foreach($sale->saleItems as $index => $item)
                                <div class="border-3 border-gray-300 rounded-xl p-6 bg-gray-50">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="text-lg font-semibold text-gray-600">Item #{{ $index + 1 }}</div>
                                    </div>
                                    <div class="text-2xl font-bold text-gray-800 mb-3">{{ $item->product->name }}</div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-lg text-gray-600">Quantity</div>
                                            <div class="text-xl font-semibold text-gray-800">{{ $item->quantity }}</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg text-gray-600">Unit Price</div>
                                            <div class="text-xl font-semibold text-gray-800">${{ number_format($item->price, 2) }}</div>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-4 border-t-2 border-gray-300">
                                        <div class="flex justify-between items-center">
                                            <div class="text-lg font-semibold text-gray-600">Subtotal</div>
                                            <div class="text-2xl font-bold text-gray-800">${{ number_format($item->subtotal, 2) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Calculation Footer -->
                    <div class="border-t-4 border-gray-300 pt-6 mb-6">
                        <div class="flex justify-end">
                            <div class="w-full md:w-96">
                                <div class="space-y-4">
                                    <div class="flex justify-between text-xl font-semibold">
                                        <span class="text-gray-700">Subtotal:</span>
                                        <span class="text-gray-900">${{ number_format($sale->subtotal, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-xl font-semibold">
                                        <span class="text-gray-700">Tax:</span>
                                        <span class="text-gray-900">${{ number_format($sale->tax, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-xl font-semibold">
                                        <span class="text-gray-700">Discount:</span>
                                        <span class="text-red-600">-${{ number_format($sale->discount, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-3xl font-bold bg-blue-50 p-5 rounded-xl border-3 border-blue-200">
                                        <span class="text-gray-800">TOTAL:</span>
                                        <span class="text-blue-600">${{ number_format($sale->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-green-50 border-3 border-green-200 rounded-xl p-6 mb-6">
                        <h3 class="text-2xl font-bold mb-4 text-green-800">Payment Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <div class="text-lg font-semibold text-gray-700 mb-2">Payment Method</div>
                                <div class="text-xl font-bold text-gray-900">
                                    <span class="px-5 py-3 inline-flex text-xl leading-5 font-semibold rounded-full
                                        {{ $sale->payment_method == 'cash' ? 'bg-green-200 text-green-900' : '' }}
                                        {{ $sale->payment_method == 'card' ? 'bg-blue-200 text-blue-900' : '' }}
                                        {{ $sale->payment_method == 'ewallet' ? 'bg-purple-200 text-purple-900' : '' }}">
                                        {{ ucfirst($sale->payment_method) }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-gray-700 mb-2">Amount Paid</div>
                                <div class="text-2xl font-bold text-gray-900">${{ number_format($sale->amount_paid, 2) }}</div>
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-gray-700 mb-2">Change</div>
                                <div class="text-2xl font-bold text-green-700">${{ number_format($sale->change, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col md:flex-row gap-4">
                        <a href="{{ route('sales.invoice', $sale) }}" target="_blank" class="flex-1 bg-green-600 text-white px-8 py-5 rounded-xl hover:bg-green-700 font-bold text-2xl text-center shadow-lg transition-all">
                            Print Invoice
                        </a>
                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this sale? Stock quantities will be restored. This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 text-white px-8 py-5 rounded-xl hover:bg-red-700 font-bold text-2xl shadow-lg transition-all">
                                Delete Sale
                            </button>
                        </form>
                        <a href="{{ route('sales.index') }}" class="flex-1 bg-gray-600 text-white px-8 py-5 rounded-xl hover:bg-gray-700 font-bold text-2xl text-center shadow-lg transition-all">
                            Back to Sales
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
