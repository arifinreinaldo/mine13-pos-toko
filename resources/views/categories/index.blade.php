<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                {{ __('Categories') }}
            </h2>
            <a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700 font-bold text-xl shadow-lg transition-all">
                + Tambah Kategori Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-4 border-green-400 text-green-700 px-8 py-6 rounded-xl mb-6 text-xl font-semibold shadow-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                <div class="p-6 sm:p-8">
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Semua Kategori</h3>

                    @if($categories->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b-4 border-gray-300">
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-800">Nama</th>
                                        <th class="px-6 py-5 text-left text-xl font-bold text-gray-800">Deskripsi</th>
                                        <th class="px-6 py-5 text-center text-xl font-bold text-gray-800">Produk</th>
                                        <th class="px-6 py-5 text-center text-xl font-bold text-gray-800">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y-2 divide-gray-200">
                                    @foreach($categories as $category)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-6">
                                                <a href="{{ route('categories.show', $category) }}" class="text-xl font-semibold text-blue-600 hover:text-blue-800 hover:underline">
                                                    {{ $category->name }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-6 text-lg text-gray-700">
                                                {{ Str::limit($category->description ?? 'Tidak ada deskripsi', 80) }}
                                            </td>
                                            <td class="px-6 py-6 text-center">
                                                <span class="inline-block bg-blue-100 text-blue-800 px-5 py-3 rounded-xl text-xl font-bold">
                                                    {{ $category->products_count ?? 0 }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-6">
                                                <div class="flex items-center justify-center gap-3">
                                                    <a href="{{ route('categories.edit', $category) }}" class="bg-yellow-400 text-gray-900 px-6 py-3 rounded-lg hover:bg-yellow-500 font-bold text-lg shadow-md transition-all border-2 border-yellow-600">
                                                        Ubah
                                                    </a>
                                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 font-bold text-lg shadow-md transition-all">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-2xl text-gray-500 mb-6">Tidak ada kategori.</p>
                            <a href="{{ route('categories.create') }}" class="inline-block bg-blue-600 text-white px-8 py-5 rounded-xl hover:bg-blue-700 font-bold text-xl shadow-lg">
                                Buat Kategori Pertama Anda
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
