<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                {{ __('Products') }}
            </h2>
            <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-6 py-4 rounded-xl hover:bg-blue-700 font-bold text-xl shadow-lg transition-all border-2 border-blue-700">
                Tambah Produk Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-4 border-green-500 text-green-900 px-8 py-6 rounded-xl mb-6 text-xl font-semibold" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Low Stock Alert -->
            @php
                $lowStockCount = $products->filter(fn($p) => $p->isLowStock())->count();
            @endphp
            @if($lowStockCount > 0)
                <div class="bg-orange-100 border-4 border-orange-500 rounded-xl mb-6 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-orange-800 mb-2">Peringatan Stok Menipis</h3>
                                <p class="text-xl text-orange-900">{{ $lowStockCount }} produk dengan stok menipis</p>
                            </div>
                            <a href="{{ route('products.low-stock') }}" class="bg-orange-600 text-white px-6 py-4 rounded-xl hover:bg-orange-700 font-bold text-xl border-2 border-orange-700 transition-all">
                                Lihat Stok Menipis
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Products Table -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-4 divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-b-4 border-gray-300">
                                        SKU
                                    </th>
                                    <th scope="col" class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-b-4 border-gray-300">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-b-4 border-gray-300">
                                        Kategori
                                    </th>
                                    <th scope="col" class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-b-4 border-gray-300">
                                        Harga
                                    </th>
                                    <th scope="col" class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-b-4 border-gray-300">
                                        Stok
                                    </th>
                                    <th scope="col" class="px-6 py-5 text-left text-xl font-bold text-gray-700 uppercase tracking-wider border-b-4 border-gray-300">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y-2 divide-gray-200">
                                @forelse($products as $product)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-6 whitespace-nowrap text-lg text-gray-900 font-semibold border-r-2 border-gray-200">
                                            {{ $product->sku }}
                                        </td>
                                        <td class="px-6 py-6 text-lg text-gray-900 font-semibold border-r-2 border-gray-200">
                                            {{ $product->name }}
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-lg text-gray-700 border-r-2 border-gray-200">
                                            <span class="px-4 py-2 inline-flex text-lg leading-5 font-semibold rounded-lg bg-blue-100 text-blue-800 border-2 border-blue-300">
                                                {{ $product->category->name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-lg text-gray-900 font-bold border-r-2 border-gray-200">
                                            {{ format_currency($product->price) }}
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap border-r-2 border-gray-200">
                                            @if($product->isLowStock())
                                                <span class="px-4 py-2 inline-flex text-xl leading-5 font-bold rounded-lg bg-red-100 text-red-800 border-3 border-red-500">
                                                    {{ $product->stock_quantity }} (RENDAH!)
                                                </span>
                                            @else
                                                <span class="px-4 py-2 inline-flex text-xl leading-5 font-semibold rounded-lg bg-green-100 text-green-800 border-2 border-green-300">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-lg font-medium space-x-3">
                                            <a href="{{ route('products.show', $product) }}" class="inline-block bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700 border-2 border-blue-700 transition-all font-bold">
                                                Lihat
                                            </a>
                                            <a href="{{ route('products.edit', $product) }}" class="inline-block bg-yellow-400 text-gray-900 px-5 py-3 rounded-lg hover:bg-yellow-500 border-2 border-yellow-600 transition-all font-bold">
                                                Ubah
                                            </a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 text-white px-5 py-3 rounded-lg hover:bg-red-700 border-2 border-red-700 transition-all font-bold">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-xl text-gray-500 font-semibold">
                                            Tidak ada produk. <a href="{{ route('products.create') }}" class="text-blue-600 hover:text-blue-800 underline font-bold">Tambah produk pertama Anda</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="mt-8 border-t-2 border-gray-200 pt-6">
                            <div class="text-lg">
                                {{ $products->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
