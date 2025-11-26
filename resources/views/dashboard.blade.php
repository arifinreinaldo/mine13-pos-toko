<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Beranda') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                    <div class="p-8">
                        <div class="text-xl font-semibold text-gray-600 mb-3">Total Produk</div>
                        <div class="text-5xl font-bold text-blue-600">{{ $stats['total_products'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                    <div class="p-8">
                        <div class="text-xl font-semibold text-gray-600 mb-3">Stok Menipis</div>
                        <div class="text-5xl font-bold text-red-600">{{ $stats['low_stock'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                    <div class="p-8">
                        <div class="text-xl font-semibold text-gray-600 mb-3">Penjualan Hari Ini</div>
                        <div class="text-5xl font-bold text-green-600">{{ $stats['today_sales'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                    <div class="p-8">
                        <div class="text-xl font-semibold text-gray-600 mb-3">Pendapatan Hari Ini</div>
                        <div class="text-5xl font-bold text-green-600">{{ format_currency($stats['today_revenue']) }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-6 text-gray-800">Aksi Cepat</h3>
                        <div class="space-y-4">
                            <a href="{{ route('pos.index') }}" class="block bg-blue-600 text-white px-8 py-5 rounded-xl text-center hover:bg-blue-700 font-bold text-xl shadow-lg transition-all">
                                🛒 Buat Penjualan
                            </a>
                            <a href="{{ route('products.create') }}" class="block bg-green-600 text-white px-8 py-5 rounded-xl text-center hover:bg-green-700 font-bold text-xl shadow-lg transition-all">
                                ➕ Tambah Produk
                            </a>
                            <a href="{{ route('reports.sales') }}" class="block bg-purple-600 text-white px-8 py-5 rounded-xl text-center hover:bg-purple-700 font-bold text-xl shadow-lg transition-all">
                                📊 Lihat Laporan
                            </a>
                        </div>
                    </div>
                </div>

                @if($stats['low_stock'] > 0)
                <div class="bg-red-50 overflow-hidden shadow-lg rounded-xl border-3 border-red-300">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-4 text-red-700">⚠️ Peringatan Stok Menipis</h3>
                        <p class="text-xl text-gray-700 mb-6 leading-relaxed">Anda memiliki <span class="font-bold text-red-600 text-2xl">{{ $stats['low_stock'] }}</span> produk dengan stok menipis.</p>
                        <a href="{{ route('products.low-stock') }}" class="inline-block bg-red-600 text-white px-8 py-4 rounded-xl hover:bg-red-700 font-bold text-xl shadow-lg">
                            Lihat Produk Stok Menipis
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
