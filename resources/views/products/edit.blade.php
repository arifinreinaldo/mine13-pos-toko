<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                {{ __('Edit Product') }}
            </h2>
            <a href="{{ route('products.index') }}" class="bg-gray-600 text-white px-6 py-4 rounded-xl hover:bg-gray-700 font-bold text-xl shadow-lg transition-all border-2 border-gray-700">
                Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                <div class="p-8">
                    <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-xl font-bold text-gray-700 mb-3">
                                Category <span class="text-red-600">*</span>
                            </label>
                            <select id="category_id" name="category_id" required
                                class="mt-2 block w-full rounded-lg border-3 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xl py-4 px-5 font-semibold @error('category_id') border-red-500 @enderror">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-lg text-red-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Product Name -->
                        <div>
                            <label for="name" class="block text-xl font-bold text-gray-700 mb-3">
                                Product Name <span class="text-red-600">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                                class="mt-2 block w-full rounded-lg border-3 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xl py-4 px-5 font-semibold @error('name') border-red-500 @enderror"
                                placeholder="Enter product name">
                            @error('name')
                                <p class="mt-2 text-lg text-red-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SKU and Barcode Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="sku" class="block text-xl font-bold text-gray-700 mb-3">
                                    SKU <span class="text-red-600">*</span>
                                </label>
                                <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required
                                    class="mt-2 block w-full rounded-lg border-3 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xl py-4 px-5 font-semibold @error('sku') border-red-500 @enderror"
                                    placeholder="e.g., PROD-001">
                                @error('sku')
                                    <p class="mt-2 text-lg text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="barcode" class="block text-xl font-bold text-gray-700 mb-3">
                                    Barcode
                                </label>
                                <input type="text" name="barcode" id="barcode" value="{{ old('barcode', $product->barcode) }}"
                                    class="mt-2 block w-full rounded-lg border-3 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xl py-4 px-5 font-semibold @error('barcode') border-red-500 @enderror"
                                    placeholder="Optional">
                                @error('barcode')
                                    <p class="mt-2 text-lg text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-xl font-bold text-gray-700 mb-3">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="mt-2 block w-full rounded-lg border-3 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xl py-4 px-5 font-semibold @error('description') border-red-500 @enderror"
                                placeholder="Enter product description (optional)">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-lg text-red-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price and Cost Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="cost" class="block text-xl font-bold text-gray-700 mb-3">
                                    Cost Price <span class="text-red-600">*</span>
                                </label>
                                <div class="mt-2 relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                        <span class="text-gray-700 text-2xl font-bold">$</span>
                                    </div>
                                    <input type="number" name="cost" id="cost" step="0.01" min="0" value="{{ old('cost', $product->cost) }}" required
                                        class="block w-full rounded-lg border-3 border-gray-300 pl-12 focus:border-blue-500 focus:ring-blue-500 text-xl py-4 px-5 font-semibold @error('cost') border-red-500 @enderror"
                                        placeholder="0.00">
                                </div>
                                @error('cost')
                                    <p class="mt-2 text-lg text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="price" class="block text-xl font-bold text-gray-700 mb-3">
                                    Selling Price <span class="text-red-600">*</span>
                                </label>
                                <div class="mt-2 relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                        <span class="text-gray-700 text-2xl font-bold">$</span>
                                    </div>
                                    <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" required
                                        class="block w-full rounded-lg border-3 border-gray-300 pl-12 focus:border-blue-500 focus:ring-blue-500 text-xl py-4 px-5 font-semibold @error('price') border-red-500 @enderror"
                                        placeholder="0.00">
                                </div>
                                @error('price')
                                    <p class="mt-2 text-lg text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Stock Quantity and Minimum Stock Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="stock_quantity" class="block text-xl font-bold text-gray-700 mb-3">
                                    Stock Quantity <span class="text-red-600">*</span>
                                </label>
                                <input type="number" name="stock_quantity" id="stock_quantity" min="0" value="{{ old('stock_quantity', $product->stock_quantity) }}" required
                                    class="mt-2 block w-full rounded-lg border-3 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xl py-4 px-5 font-semibold @error('stock_quantity') border-red-500 @enderror"
                                    placeholder="0">
                                @error('stock_quantity')
                                    <p class="mt-2 text-lg text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="minimum_stock" class="block text-xl font-bold text-gray-700 mb-3">
                                    Minimum Stock Alert <span class="text-red-600">*</span>
                                </label>
                                <input type="number" name="minimum_stock" id="minimum_stock" min="0" value="{{ old('minimum_stock', $product->minimum_stock) }}" required
                                    class="mt-2 block w-full rounded-lg border-3 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xl py-4 px-5 font-semibold @error('minimum_stock') border-red-500 @enderror"
                                    placeholder="5">
                                @error('minimum_stock')
                                    <p class="mt-2 text-lg text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-lg text-gray-600">Alert when stock falls to or below this level</p>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t-2 border-gray-200">
                            <a href="{{ route('products.index') }}" class="bg-gray-300 text-gray-800 px-8 py-4 rounded-xl hover:bg-gray-400 font-bold text-xl border-2 border-gray-400 transition-all">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700 font-bold text-xl shadow-lg border-2 border-blue-700 transition-all">
                                Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
