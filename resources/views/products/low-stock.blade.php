<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                {{ __('Low Stock Products') }}
            </h2>
            <a href="{{ route('products.index') }}" class="bg-gray-600 text-white px-6 py-4 rounded-xl hover:bg-gray-700 font-bold text-xl shadow-lg transition-all border-2 border-gray-700">
                Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Warning Banner -->
            <div class="bg-red-100 border-4 border-red-500 rounded-xl mb-6 overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-16 w-16 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-3xl font-bold text-red-800 mb-3">LOW STOCK ALERT!</h3>
                            <p class="text-2xl text-red-900 font-semibold">
                                @if($products->count() > 0)
                                    {{ $products->count() }} product(s) are at or below minimum stock levels. Please restock soon!
                                @else
                                    All products are adequately stocked.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($products->count() > 0)
                <!-- Low Stock Products Table -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                    <div class="p-8">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y-4 divide-gray-200">
                                <thead class="bg-red-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-5 text-left text-xl font-bold text-red-800 uppercase tracking-wider border-b-4 border-red-300">
                                            Product Name
                                        </th>
                                        <th scope="col" class="px-6 py-5 text-left text-xl font-bold text-red-800 uppercase tracking-wider border-b-4 border-red-300">
                                            SKU
                                        </th>
                                        <th scope="col" class="px-6 py-5 text-left text-xl font-bold text-red-800 uppercase tracking-wider border-b-4 border-red-300">
                                            Category
                                        </th>
                                        <th scope="col" class="px-6 py-5 text-left text-xl font-bold text-red-800 uppercase tracking-wider border-b-4 border-red-300">
                                            Current Stock
                                        </th>
                                        <th scope="col" class="px-6 py-5 text-left text-xl font-bold text-red-800 uppercase tracking-wider border-b-4 border-red-300">
                                            Minimum Stock
                                        </th>
                                        <th scope="col" class="px-6 py-5 text-left text-xl font-bold text-red-800 uppercase tracking-wider border-b-4 border-red-300">
                                            Deficit
                                        </th>
                                        <th scope="col" class="px-6 py-5 text-left text-xl font-bold text-red-800 uppercase tracking-wider border-b-4 border-red-300">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y-3 divide-red-100">
                                    @foreach($products as $product)
                                        @php
                                            $deficit = $product->minimum_stock - $product->stock_quantity;
                                            $severityClass = $product->stock_quantity == 0 ? 'bg-red-200' : 'bg-orange-50';
                                        @endphp
                                        <tr class="hover:bg-red-50 transition-colors {{ $severityClass }}">
                                            <td class="px-6 py-6 text-xl text-gray-900 font-bold border-r-2 border-gray-200">
                                                {{ $product->name }}
                                                @if($product->stock_quantity == 0)
                                                    <span class="ml-2 px-3 py-1 text-lg font-bold rounded-lg bg-red-600 text-white border-2 border-red-700">OUT OF STOCK</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-6 whitespace-nowrap text-lg text-gray-900 font-semibold border-r-2 border-gray-200">
                                                {{ $product->sku }}
                                            </td>
                                            <td class="px-6 py-6 whitespace-nowrap text-lg text-gray-700 border-r-2 border-gray-200">
                                                <span class="px-4 py-2 inline-flex text-lg leading-5 font-semibold rounded-lg bg-blue-100 text-blue-800 border-2 border-blue-300">
                                                    {{ $product->category->name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-6 whitespace-nowrap border-r-2 border-gray-200">
                                                <span class="px-5 py-3 inline-flex text-2xl leading-5 font-bold rounded-lg bg-red-100 text-red-900 border-3 border-red-500">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-6 whitespace-nowrap border-r-2 border-gray-200">
                                                <span class="px-5 py-3 inline-flex text-2xl leading-5 font-semibold rounded-lg bg-orange-100 text-orange-900 border-2 border-orange-400">
                                                    {{ $product->minimum_stock }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-6 whitespace-nowrap border-r-2 border-gray-200">
                                                <span class="px-5 py-3 inline-flex text-2xl leading-5 font-bold rounded-lg bg-yellow-100 text-yellow-900 border-3 border-yellow-500">
                                                    {{ $deficit > 0 ? $deficit : 0 }} units needed
                                                </span>
                                            </td>
                                            <td class="px-6 py-6 whitespace-nowrap text-lg font-medium">
                                                <a href="{{ route('products.edit', $product) }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 border-2 border-indigo-700 transition-all font-bold">
                                                    Restock
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="mt-6 bg-orange-50 overflow-hidden shadow-lg rounded-xl border-3 border-orange-300">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-orange-800 mb-4">Restocking Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-white p-6 rounded-lg border-2 border-orange-200">
                                <dt class="text-xl font-bold text-orange-700 mb-2">Total Low Stock Items</dt>
                                <dd class="text-4xl font-bold text-orange-900">{{ $products->count() }}</dd>
                            </div>
                            <div class="bg-white p-6 rounded-lg border-2 border-red-200">
                                <dt class="text-xl font-bold text-red-700 mb-2">Out of Stock</dt>
                                <dd class="text-4xl font-bold text-red-900">{{ $products->where('stock_quantity', 0)->count() }}</dd>
                            </div>
                            <div class="bg-white p-6 rounded-lg border-2 border-yellow-200">
                                <dt class="text-xl font-bold text-yellow-700 mb-2">Total Units Needed</dt>
                                <dd class="text-4xl font-bold text-yellow-900">
                                    {{ $products->sum(fn($p) => max(0, $p->minimum_stock - $p->stock_quantity)) }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- No Low Stock Products -->
                <div class="bg-green-50 overflow-hidden shadow-lg rounded-xl border-3 border-green-300">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-24 w-24 text-green-600 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-3xl font-bold text-green-800 mb-4">All Stock Levels Are Good!</h3>
                        <p class="text-2xl text-green-700 mb-6">All products are currently above their minimum stock levels.</p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-green-600 text-white px-8 py-4 rounded-xl hover:bg-green-700 font-bold text-xl shadow-lg border-2 border-green-700 transition-all">
                            View All Products
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
