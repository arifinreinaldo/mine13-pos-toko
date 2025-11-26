<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Sales Report') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Date Range Filter -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200 mb-8">
                <div class="p-8">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Filter by Date Range</h3>
                    <form method="GET" action="{{ route('reports.sales') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="start_date" class="block text-xl font-semibold text-gray-700 mb-3">Start Date</label>
                            <input type="date"
                                   id="start_date"
                                   name="start_date"
                                   value="{{ request('start_date', $startDate instanceof \Carbon\Carbon ? $startDate->format('Y-m-d') : $startDate) }}"
                                   class="w-full px-6 py-4 border-3 border-gray-300 rounded-xl text-xl focus:ring-4 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="end_date" class="block text-xl font-semibold text-gray-700 mb-3">End Date</label>
                            <input type="date"
                                   id="end_date"
                                   name="end_date"
                                   value="{{ request('end_date', $endDate instanceof \Carbon\Carbon ? $endDate->format('Y-m-d') : $endDate) }}"
                                   class="w-full px-6 py-4 border-3 border-gray-300 rounded-xl text-xl focus:ring-4 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-blue-600 text-white px-8 py-5 rounded-xl hover:bg-blue-700 font-bold text-xl shadow-lg transition-all">
                                Apply Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                    <div class="p-8">
                        <div class="text-xl font-semibold text-gray-600 mb-3">Total Sales</div>
                        <div class="text-5xl font-bold text-green-600">${{ number_format($totalSales, 2) }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                    <div class="p-8">
                        <div class="text-xl font-semibold text-gray-600 mb-3">Total Profit</div>
                        <div class="text-5xl font-bold text-blue-600">${{ number_format($totalProfit, 2) }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                    <div class="p-8">
                        <div class="text-xl font-semibold text-gray-600 mb-3">Transactions</div>
                        <div class="text-5xl font-bold text-purple-600">{{ $sales->count() }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                    <div class="p-8">
                        <div class="text-xl font-semibold text-gray-600 mb-3">Average Sale</div>
                        <div class="text-5xl font-bold text-orange-600">
                            ${{ $sales->count() > 0 ? number_format($totalSales / $sales->count(), 2) : '0.00' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales by Day Chart/Table -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200 mb-8">
                <div class="p-8">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Sales by Day</h3>
                    @if($salesByDay->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y-2 divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Date
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Total Sales
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y-2 divide-gray-200">
                                    @foreach($salesByDay as $day)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-5 whitespace-nowrap text-xl font-medium text-gray-900 border-2 border-gray-200">
                                                {{ \Carbon\Carbon::parse($day->date)->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right text-gray-900 border-2 border-gray-200">
                                                ${{ number_format($day->total, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-100">
                                    <tr>
                                        <td class="px-6 py-5 text-xl font-bold text-gray-900 border-2 border-gray-300">
                                            Total
                                        </td>
                                        <td class="px-6 py-5 text-xl font-bold text-right text-gray-900 border-2 border-gray-300">
                                            ${{ number_format($salesByDay->sum('total'), 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <p class="text-xl text-gray-500 py-6">No sales data available for the selected period.</p>
                    @endif
                </div>
            </div>

            <!-- Top 10 Products -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200 mb-8">
                <div class="p-8">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Top 10 Products</h3>
                    @if($topProducts->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y-2 divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Rank
                                        </th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Product
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Qty Sold
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Total Sales
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y-2 divide-gray-200">
                                    @foreach($topProducts as $index => $product)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-5 whitespace-nowrap text-xl font-bold text-gray-900 border-2 border-gray-200">
                                                #{{ $index + 1 }}
                                            </td>
                                            <td class="px-6 py-5 text-xl text-gray-900 border-2 border-gray-200">
                                                {{ $product->name }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right text-gray-900 border-2 border-gray-200">
                                                {{ number_format($product->total_quantity) }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right font-semibold text-green-600 border-2 border-gray-200">
                                                ${{ number_format($product->total_sales, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-xl text-gray-500 py-6">No product sales data available for the selected period.</p>
                    @endif
                </div>
            </div>

            <!-- Detailed Sales List -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                <div class="p-8">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Detailed Sales List</h3>
                    @if($sales->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y-2 divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Invoice #
                                        </th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Date
                                        </th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Cashier
                                        </th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Items
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Subtotal
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Tax
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Total
                                        </th>
                                        <th class="px-6 py-5 text-center text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y-2 divide-gray-200">
                                    @foreach($sales as $sale)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-5 whitespace-nowrap text-xl font-medium text-blue-600 border-2 border-gray-200">
                                                {{ $sale->invoice_number }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-gray-900 border-2 border-gray-200">
                                                {{ $sale->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-gray-900 border-2 border-gray-200">
                                                {{ $sale->user->name }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-gray-900 border-2 border-gray-200">
                                                {{ $sale->saleItems->count() }} item(s)
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right text-gray-900 border-2 border-gray-200">
                                                ${{ number_format($sale->subtotal, 2) }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right text-gray-900 border-2 border-gray-200">
                                                ${{ number_format($sale->tax, 2) }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right font-semibold text-green-600 border-2 border-gray-200">
                                                ${{ number_format($sale->total, 2) }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-center border-2 border-gray-200">
                                                <a href="{{ route('sales.show', $sale) }}"
                                                   class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold text-lg">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-xl text-gray-500 py-6">No sales records found for the selected period.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
