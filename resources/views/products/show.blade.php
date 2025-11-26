<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                {{ __('Product Details') }}
            </h2>
            <a href="{{ route('products.index') }}" class="bg-gray-600 text-white px-6 py-4 rounded-xl hover:bg-gray-700 font-bold text-xl shadow-lg transition-all border-2 border-gray-700">
                Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Low Stock Alert -->
            @if($product->isLowStock())
                <div class="bg-red-100 border-4 border-red-500 rounded-xl mb-6 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-12 w-12 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-2xl font-bold text-red-800 mb-2">LOW STOCK WARNING!</h3>
                                <p class="text-xl text-red-900 font-semibold">This product is running low on stock. Current stock: {{ $product->stock_quantity }} (Minimum: {{ $product->minimum_stock }})</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Product Details Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                <div class="p-8">
                    <div class="space-y-8">
                        <!-- Product Name and Category -->
                        <div class="border-b-4 border-gray-200 pb-6">
                            <h3 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h3>
                            <span class="inline-flex items-center px-6 py-3 rounded-lg text-xl font-bold bg-blue-100 text-blue-800 border-3 border-blue-300">
                                {{ $product->category->name }}
                            </span>
                        </div>

                        <!-- SKU and Barcode -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-6 rounded-lg border-2 border-gray-200">
                                <dt class="text-xl font-bold text-gray-600 mb-2">SKU</dt>
                                <dd class="text-2xl font-bold text-gray-900">{{ $product->sku }}</dd>
                            </div>
                            @if($product->barcode)
                                <div class="bg-gray-50 p-6 rounded-lg border-2 border-gray-200">
                                    <dt class="text-xl font-bold text-gray-600 mb-2">Barcode</dt>
                                    <dd class="text-2xl font-bold text-gray-900">{{ $product->barcode }}</dd>
                                </div>
                            @endif
                        </div>

                        <!-- Description -->
                        @if($product->description)
                            <div class="bg-gray-50 p-6 rounded-lg border-2 border-gray-200">
                                <dt class="text-xl font-bold text-gray-600 mb-3">Description</dt>
                                <dd class="text-xl text-gray-900 leading-relaxed">{{ $product->description }}</dd>
                            </div>
                        @endif

                        <!-- Pricing Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-green-50 p-6 rounded-lg border-3 border-green-300">
                                <dt class="text-xl font-bold text-green-700 mb-2">Cost Price</dt>
                                <dd class="text-3xl font-bold text-green-900">${{ number_format($product->cost, 2) }}</dd>
                            </div>
                            <div class="bg-blue-50 p-6 rounded-lg border-3 border-blue-300">
                                <dt class="text-xl font-bold text-blue-700 mb-2">Selling Price</dt>
                                <dd class="text-3xl font-bold text-blue-900">${{ number_format($product->price, 2) }}</dd>
                            </div>
                        </div>

                        <!-- Profit Margin -->
                        @php
                            $profit = $product->price - $product->cost;
                            $profitMargin = $product->cost > 0 ? (($profit / $product->cost) * 100) : 0;
                        @endphp
                        <div class="bg-purple-50 p-6 rounded-lg border-3 border-purple-300">
                            <dt class="text-xl font-bold text-purple-700 mb-2">Profit Margin</dt>
                            <dd class="text-3xl font-bold text-purple-900">
                                ${{ number_format($profit, 2) }} ({{ number_format($profitMargin, 1) }}%)
                            </dd>
                        </div>

                        <!-- Stock Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="@if($product->isLowStock()) bg-red-50 border-red-500 @else bg-green-50 border-green-300 @endif p-6 rounded-lg border-3">
                                <dt class="text-xl font-bold @if($product->isLowStock()) text-red-700 @else text-green-700 @endif mb-2">
                                    Current Stock
                                </dt>
                                <dd class="text-3xl font-bold @if($product->isLowStock()) text-red-900 @else text-green-900 @endif">
                                    {{ $product->stock_quantity }} units
                                    @if($product->isLowStock())
                                        <span class="text-2xl ml-2">⚠️</span>
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-orange-50 p-6 rounded-lg border-3 border-orange-300">
                                <dt class="text-xl font-bold text-orange-700 mb-2">Minimum Stock Level</dt>
                                <dd class="text-3xl font-bold text-orange-900">{{ $product->minimum_stock }} units</dd>
                            </div>
                        </div>

                        <!-- Timestamps -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t-2 border-gray-200">
                            <div>
                                <dt class="text-lg font-bold text-gray-600 mb-2">Created At</dt>
                                <dd class="text-xl text-gray-900">{{ $product->created_at->format('M d, Y h:i A') }}</dd>
                            </div>
                            <div>
                                <dt class="text-lg font-bold text-gray-600 mb-2">Last Updated</dt>
                                <dd class="text-xl text-gray-900">{{ $product->updated_at->format('M d, Y h:i A') }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-gray-50 px-8 py-6 border-t-2 border-gray-200">
                    <div class="flex flex-wrap gap-4 justify-end">
                        <a href="{{ route('products.edit', $product) }}" class="bg-indigo-600 text-white px-8 py-4 rounded-xl hover:bg-indigo-700 font-bold text-xl shadow-lg border-2 border-indigo-700 transition-all">
                            Edit Product
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-8 py-4 rounded-xl hover:bg-red-700 font-bold text-xl shadow-lg border-2 border-red-700 transition-all">
                                Delete Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
