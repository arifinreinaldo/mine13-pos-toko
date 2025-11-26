<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Inventory Report') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Total Inventory Value Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200 mb-8">
                <div class="p-8">
                    <div class="text-xl font-semibold text-gray-600 mb-3">Total Inventory Value</div>
                    <div class="text-5xl font-bold text-blue-600">${{ number_format($totalValue, 2) }}</div>
                    <p class="text-lg text-gray-500 mt-4">Based on {{ $products->count() }} total products</p>
                </div>
            </div>

            <!-- Low Stock Alerts Section -->
            @if($lowStockProducts->count() > 0)
                <div class="bg-red-50 overflow-hidden shadow-lg rounded-xl border-3 border-red-300 mb-8">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-4 text-red-700">Low Stock Alert</h3>
                        <p class="text-xl text-gray-700 mb-6 leading-relaxed">
                            You have <span class="font-bold text-red-600 text-2xl">{{ $lowStockProducts->count() }}</span> product(s) with low stock that need attention.
                        </p>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y-2 divide-red-200">
                                <thead class="bg-red-100">
                                    <tr>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-red-900 uppercase tracking-wider border-2 border-red-200">
                                            SKU
                                        </th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-red-900 uppercase tracking-wider border-2 border-red-200">
                                            Product
                                        </th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-red-900 uppercase tracking-wider border-2 border-red-200">
                                            Category
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-red-900 uppercase tracking-wider border-2 border-red-200">
                                            Current Stock
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-red-900 uppercase tracking-wider border-2 border-red-200">
                                            Minimum Stock
                                        </th>
                                        <th class="px-6 py-5 text-center text-xl font-bold text-red-900 uppercase tracking-wider border-2 border-red-200">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y-2 divide-red-200">
                                    @foreach($lowStockProducts as $product)
                                        <tr class="hover:bg-red-50">
                                            <td class="px-6 py-5 whitespace-nowrap text-xl font-medium text-gray-900 border-2 border-red-200">
                                                {{ $product->sku }}
                                            </td>
                                            <td class="px-6 py-5 text-xl text-gray-900 border-2 border-red-200">
                                                {{ $product->name }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-gray-900 border-2 border-red-200">
                                                {{ $product->category->name }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right font-bold text-red-600 border-2 border-red-200">
                                                {{ number_format($product->stock_quantity) }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right text-gray-900 border-2 border-red-200">
                                                {{ number_format($product->minimum_stock) }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-center border-2 border-red-200">
                                                @if($product->stock_quantity == 0)
                                                    <span class="inline-flex px-5 py-2 text-lg font-bold leading-5 rounded-full bg-red-600 text-white">
                                                        OUT OF STOCK
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-5 py-2 text-lg font-bold leading-5 rounded-full bg-orange-500 text-white">
                                                        LOW STOCK
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-green-50 overflow-hidden shadow-lg rounded-xl border-2 border-green-300 mb-8">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-4 text-green-700">Inventory Status</h3>
                        <p class="text-xl text-gray-700 leading-relaxed">
                            All products are adequately stocked. No low stock alerts at this time.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Category Inventory Breakdown -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200 mb-8">
                <div class="p-8">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Category Inventory Breakdown</h3>
                    @if($categoryInventory->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y-2 divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Category
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Total Quantity
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Total Value
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            % of Total Value
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y-2 divide-gray-200">
                                    @foreach($categoryInventory as $category)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-5 text-xl font-medium text-gray-900 border-2 border-gray-200">
                                                {{ $category->name }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right text-gray-900 border-2 border-gray-200">
                                                {{ number_format($category->total_quantity) }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right font-semibold text-green-600 border-2 border-gray-200">
                                                ${{ number_format($category->total_value, 2) }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right text-gray-900 border-2 border-gray-200">
                                                {{ $totalValue > 0 ? number_format(($category->total_value / $totalValue) * 100, 1) : '0.0' }}%
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
                                            {{ number_format($categoryInventory->sum('total_quantity')) }}
                                        </td>
                                        <td class="px-6 py-5 text-xl font-bold text-right text-gray-900 border-2 border-gray-300">
                                            ${{ number_format($categoryInventory->sum('total_value'), 2) }}
                                        </td>
                                        <td class="px-6 py-5 text-xl font-bold text-right text-gray-900 border-2 border-gray-300">
                                            100.0%
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <p class="text-xl text-gray-500 py-6">No inventory data available.</p>
                    @endif
                </div>
            </div>

            <!-- Full Inventory Table -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                <div class="p-8">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Full Inventory List</h3>
                    @if($products->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y-2 divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            SKU
                                        </th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Name
                                        </th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Category
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Stock Qty
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Unit Cost
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Unit Price
                                        </th>
                                        <th class="px-6 py-5 text-right text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Total Value
                                        </th>
                                        <th class="px-6 py-5 text-center text-xl font-bold text-gray-700 uppercase tracking-wider border-2 border-gray-200">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y-2 divide-gray-200">
                                    @foreach($products as $product)
                                        <tr class="hover:bg-gray-50 {{ $product->isLowStock() ? 'bg-red-50' : '' }}">
                                            <td class="px-6 py-5 whitespace-nowrap text-xl font-medium text-gray-900 border-2 border-gray-200">
                                                {{ $product->sku }}
                                            </td>
                                            <td class="px-6 py-5 text-xl text-gray-900 border-2 border-gray-200">
                                                {{ $product->name }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-gray-900 border-2 border-gray-200">
                                                {{ $product->category->name }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right border-2 border-gray-200
                                                {{ $product->isLowStock() ? 'font-bold text-red-600' : 'text-gray-900' }}">
                                                {{ number_format($product->stock_quantity) }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right text-gray-900 border-2 border-gray-200">
                                                ${{ number_format($product->cost, 2) }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right text-gray-900 border-2 border-gray-200">
                                                ${{ number_format($product->price, 2) }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-xl text-right font-semibold text-green-600 border-2 border-gray-200">
                                                ${{ number_format($product->stock_quantity * $product->cost, 2) }}
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-center border-2 border-gray-200">
                                                @if($product->stock_quantity == 0)
                                                    <span class="inline-flex px-5 py-2 text-lg font-bold leading-5 rounded-full bg-red-600 text-white">
                                                        OUT OF STOCK
                                                    </span>
                                                @elseif($product->isLowStock())
                                                    <span class="inline-flex px-5 py-2 text-lg font-bold leading-5 rounded-full bg-orange-500 text-white">
                                                        LOW STOCK
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-5 py-2 text-lg font-bold leading-5 rounded-full bg-green-600 text-white">
                                                        IN STOCK
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-xl text-gray-500 py-6">No products found in inventory.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
