<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                {{ __('Sales History') }}
            </h2>
            <a href="{{ route('pos.index') }}" class="bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700 font-bold text-xl shadow-lg transition-all">
                + New Sale
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-3 border-green-500 text-green-800 px-8 py-6 rounded-xl mb-6 text-xl font-semibold shadow-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                <div class="p-6 sm:p-8">
                    <h3 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800">All Sales Transactions</h3>

                    @if($sales->count() > 0)
                        <!-- Desktop Table -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y-2 divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-800 uppercase tracking-wider border-b-3 border-gray-300">
                                            Invoice #
                                        </th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-800 uppercase tracking-wider border-b-3 border-gray-300">
                                            Date
                                        </th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-800 uppercase tracking-wider border-b-3 border-gray-300">
                                            Customer
                                        </th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-800 uppercase tracking-wider border-b-3 border-gray-300">
                                            Total
                                        </th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-800 uppercase tracking-wider border-b-3 border-gray-300">
                                            Payment Method
                                        </th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-800 uppercase tracking-wider border-b-3 border-gray-300">
                                            Cashier
                                        </th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-800 uppercase tracking-wider border-b-3 border-gray-300">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y-2 divide-gray-200">
                                    @foreach($sales as $sale)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-5 whitespace-nowrap text-xl font-bold text-blue-600">
                                                {{ $sale->invoice_number }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-gray-800">
                                                {{ $sale->created_at->format('Y-m-d H:i') }}
                                            </td>
                                            <td class="px-6 py-5 text-xl text-gray-800">
                                                {{ $sale->customer ? $sale->customer->name : 'Walk-in Customer' }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl font-bold text-green-600">
                                                ${{ number_format($sale->total, 2) }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-gray-800">
                                                <span class="px-4 py-2 inline-flex text-lg leading-5 font-semibold rounded-full
                                                    {{ $sale->payment_method == 'cash' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $sale->payment_method == 'card' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $sale->payment_method == 'ewallet' ? 'bg-purple-100 text-purple-800' : '' }}">
                                                    {{ ucfirst($sale->payment_method) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5 text-xl text-gray-800">
                                                {{ $sale->user->name }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('sales.show', $sale) }}" class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700 font-semibold text-lg shadow-md transition-all">
                                                        View
                                                    </a>
                                                    <a href="{{ route('sales.invoice', $sale) }}" target="_blank" class="bg-green-600 text-white px-5 py-3 rounded-lg hover:bg-green-700 font-semibold text-lg shadow-md transition-all">
                                                        Print
                                                    </a>
                                                    <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this sale? Stock quantities will be restored.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-600 text-white px-5 py-3 rounded-lg hover:bg-red-700 font-semibold text-lg shadow-md transition-all">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Cards -->
                        <div class="md:hidden space-y-4">
                            @foreach($sales as $sale)
                                <div class="border-3 border-gray-300 rounded-xl p-6 shadow-md hover:border-blue-500 transition-all">
                                    <div class="mb-4">
                                        <div class="text-lg font-semibold text-gray-600">Invoice Number</div>
                                        <div class="text-2xl font-bold text-blue-600">{{ $sale->invoice_number }}</div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="text-lg font-semibold text-gray-600">Date</div>
                                        <div class="text-xl text-gray-800">{{ $sale->created_at->format('Y-m-d H:i') }}</div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="text-lg font-semibold text-gray-600">Customer</div>
                                        <div class="text-xl text-gray-800">{{ $sale->customer ? $sale->customer->name : 'Walk-in Customer' }}</div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="text-lg font-semibold text-gray-600">Total</div>
                                        <div class="text-2xl font-bold text-green-600">${{ number_format($sale->total, 2) }}</div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="text-lg font-semibold text-gray-600">Payment Method</div>
                                        <div class="text-xl">
                                            <span class="px-4 py-2 inline-flex text-lg leading-5 font-semibold rounded-full
                                                {{ $sale->payment_method == 'cash' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $sale->payment_method == 'card' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $sale->payment_method == 'ewallet' ? 'bg-purple-100 text-purple-800' : '' }}">
                                                {{ ucfirst($sale->payment_method) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="text-lg font-semibold text-gray-600">Cashier</div>
                                        <div class="text-xl text-gray-800">{{ $sale->user->name }}</div>
                                    </div>
                                    <div class="flex flex-col space-y-2 mt-5">
                                        <a href="{{ route('sales.show', $sale) }}" class="bg-blue-600 text-white px-6 py-4 rounded-xl hover:bg-blue-700 font-bold text-xl text-center shadow-lg transition-all">
                                            View Details
                                        </a>
                                        <a href="{{ route('sales.invoice', $sale) }}" target="_blank" class="bg-green-600 text-white px-6 py-4 rounded-xl hover:bg-green-700 font-bold text-xl text-center shadow-lg transition-all">
                                            Print Invoice
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this sale? Stock quantities will be restored.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-600 text-white px-6 py-4 rounded-xl hover:bg-red-700 font-bold text-xl shadow-lg transition-all">
                                                Delete Sale
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $sales->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-6">📊</div>
                            <p class="text-2xl text-gray-600 font-semibold mb-8">No sales found</p>
                            <a href="{{ route('pos.index') }}" class="inline-block bg-blue-600 text-white px-10 py-5 rounded-xl hover:bg-blue-700 font-bold text-2xl shadow-lg transition-all">
                                Make Your First Sale
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
