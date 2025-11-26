<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                {{ $category->name }}
            </h2>
            <a href="{{ route('categories.edit', $category) }}" class="bg-indigo-600 text-white px-8 py-4 rounded-xl hover:bg-indigo-700 font-bold text-xl shadow-lg transition-all">
                Edit Category
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Category Details Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200 mb-8">
                <div class="p-6 sm:p-8">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Category Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-6 rounded-xl border-2 border-gray-200">
                            <div class="text-lg font-semibold text-gray-600 mb-2">Category Name</div>
                            <div class="text-2xl font-bold text-gray-800">{{ $category->name }}</div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-xl border-2 border-gray-200">
                            <div class="text-lg font-semibold text-gray-600 mb-2">Total Products</div>
                            <div class="text-2xl font-bold text-blue-600">{{ $category->products->count() }} products</div>
                        </div>
                    </div>

                    @if($category->description)
                    <div class="mt-6 bg-blue-50 p-6 rounded-xl border-2 border-blue-200">
                        <div class="text-lg font-semibold text-gray-700 mb-2">Description</div>
                        <div class="text-xl text-gray-800 leading-relaxed">{{ $category->description }}</div>
                    </div>
                    @endif

                    <div class="mt-6 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('categories.index') }}" class="inline-block bg-gray-500 text-white px-8 py-4 rounded-xl hover:bg-gray-600 font-bold text-xl shadow-lg transition-all text-center">
                            Back to Categories
                        </a>
                        <a href="{{ route('products.create') }}?category_id={{ $category->id }}" class="inline-block bg-green-600 text-white px-8 py-4 rounded-xl hover:bg-green-700 font-bold text-xl shadow-lg transition-all text-center">
                            + Add Product to Category
                        </a>
                    </div>
                </div>
            </div>

            <!-- Products in Category -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                <div class="p-6 sm:p-8">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Products in This Category</h3>

                    @if($category->products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($category->products as $product)
                                <div class="border-3 border-gray-300 rounded-xl p-6 hover:border-blue-500 hover:bg-blue-50 transition-all shadow-md">
                                    <div class="mb-4">
                                        <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $product->name }}</h4>
                                        <div class="text-3xl font-bold text-blue-600 mb-3">${{ number_format($product->price, 2) }}</div>
                                    </div>

                                    <div class="space-y-2 mb-4">
                                        <div class="flex justify-between text-lg">
                                            <span class="text-gray-600">Stock:</span>
                                            <span class="font-bold {{ $product->stock_quantity <= $product->minimum_stock ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $product->stock_quantity }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between text-lg">
                                            <span class="text-gray-600">Min Stock:</span>
                                            <span class="font-semibold text-gray-800">{{ $product->minimum_stock }}</span>
                                        </div>
                                    </div>

                                    @if($product->stock_quantity <= $product->minimum_stock)
                                        <div class="mb-4 bg-red-100 border-2 border-red-300 text-red-700 px-4 py-3 rounded-lg text-sm font-bold">
                                            Low Stock Alert
                                        </div>
                                    @endif

                                    <div class="flex gap-3">
                                        <a href="{{ route('products.edit', $product) }}" class="flex-1 bg-indigo-600 text-white px-5 py-3 rounded-lg hover:bg-indigo-700 font-bold text-lg text-center shadow-md transition-all">
                                            Edit
                                        </a>
                                        <a href="{{ route('products.show', $product) }}" class="flex-1 bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700 font-bold text-lg text-center shadow-md transition-all">
                                            View
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-gray-300">
                            <p class="text-2xl text-gray-500 mb-6">No products in this category yet.</p>
                            <a href="{{ route('products.create') }}?category_id={{ $category->id }}" class="inline-block bg-green-600 text-white px-8 py-5 rounded-xl hover:bg-green-700 font-bold text-xl shadow-lg">
                                Add Your First Product
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
