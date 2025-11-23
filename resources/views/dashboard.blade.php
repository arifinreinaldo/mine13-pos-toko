<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">Total Products</div>
                        <div class="text-2xl font-bold">{{ $stats['total_products'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">Low Stock Items</div>
                        <div class="text-2xl font-bold text-red-600">{{ $stats['low_stock'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">Today's Sales</div>
                        <div class="text-2xl font-bold">{{ $stats['today_sales'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600">Today's Revenue</div>
                        <div class="text-2xl font-bold">${{ number_format($stats['today_revenue'], 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('pos.index') }}" class="block bg-blue-500 text-white px-4 py-2 rounded text-center hover:bg-blue-600">
                                Make a Sale
                            </a>
                            <a href="{{ route('products.create') }}" class="block bg-green-500 text-white px-4 py-2 rounded text-center hover:bg-green-600">
                                Add Product
                            </a>
                            <a href="{{ route('reports.sales') }}" class="block bg-purple-500 text-white px-4 py-2 rounded text-center hover:bg-purple-600">
                                View Reports
                            </a>
                        </div>
                    </div>
                </div>

                @if($stats['low_stock'] > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-red-600">Low Stock Alert</h3>
                        <p class="text-gray-600 mb-2">You have {{ $stats['low_stock'] }} product(s) with low stock.</p>
                        <a href="{{ route('products.low-stock') }}" class="text-blue-600 hover:underline">
                            View Low Stock Products
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
