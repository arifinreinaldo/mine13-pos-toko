<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Add New Category') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf

                        <!-- Name Field -->
                        <div class="mb-8">
                            <label for="name" class="block text-xl font-bold text-gray-800 mb-3">
                                Category Name <span class="text-red-600">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-6 py-5 text-xl border-3 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                   placeholder="Enter category name">
                            @error('name')
                                <p class="text-red-600 text-lg mt-3 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div class="mb-8">
                            <label for="description" class="block text-xl font-bold text-gray-800 mb-3">
                                Description <span class="text-gray-500 text-lg font-normal">(Optional)</span>
                            </label>
                            <textarea name="description"
                                      id="description"
                                      rows="5"
                                      class="w-full px-6 py-5 text-xl border-3 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                      placeholder="Enter category description">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-lg mt-3 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t-4 border-gray-200">
                            <button type="submit" class="w-full sm:w-auto bg-green-600 text-white px-10 py-5 rounded-xl hover:bg-green-700 font-bold text-2xl shadow-lg transition-all">
                                Save Category
                            </button>
                            <a href="{{ route('categories.index') }}" class="w-full sm:w-auto bg-gray-500 text-white px-10 py-5 rounded-xl hover:bg-gray-600 font-bold text-2xl shadow-lg transition-all text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Text -->
            <div class="mt-6 bg-blue-50 border-2 border-blue-200 rounded-xl p-6">
                <p class="text-lg text-gray-700 leading-relaxed">
                    <span class="font-bold text-blue-800">Tip:</span> Categories help organize your products and make them easier to find in the POS system. Choose clear, descriptive names like "Electronics", "Clothing", or "Food & Beverages".
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
