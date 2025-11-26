<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                {{ __('Customers') }}
            </h2>
            <a href="{{ route('customers.create') }}" class="bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700 font-bold text-xl shadow-lg transition-all">
                + Add New Customer
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                <div class="p-6 sm:p-8">
                    @if(session('success'))
                        <div class="bg-green-100 border-3 border-green-500 text-green-800 px-6 py-5 rounded-xl mb-6 text-xl font-semibold shadow-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Search Box -->
                    <div class="mb-6">
                        <label class="block text-xl font-semibold mb-3 text-gray-700">Search Customers:</label>
                        <input type="text" id="customerSearch" placeholder="Search by name, code, or phone..."
                               class="w-full px-6 py-5 text-2xl border-3 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500"
                               onkeyup="filterCustomers()">
                    </div>

                    <!-- Desktop Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full border-3 border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 border-b-3 border-gray-300">Customer Code</th>
                                    <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 border-b-3 border-gray-300">Name</th>
                                    <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 border-b-3 border-gray-300">Email</th>
                                    <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 border-b-3 border-gray-300">Phone</th>
                                    <th class="px-6 py-5 text-left text-xl font-bold text-gray-700 border-b-3 border-gray-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="customerTableBody">
                                @forelse($customers as $customer)
                                    <tr class="customer-row hover:bg-gray-50 transition-colors"
                                        data-search="{{ strtolower($customer->customer_code . ' ' . $customer->name . ' ' . $customer->email . ' ' . $customer->phone) }}">
                                        <td class="px-6 py-5 border-b-2 border-gray-200 text-lg font-semibold text-gray-900">
                                            {{ $customer->customer_code }}
                                        </td>
                                        <td class="px-6 py-5 border-b-2 border-gray-200 text-lg font-semibold text-gray-900">
                                            {{ $customer->name }}
                                        </td>
                                        <td class="px-6 py-5 border-b-2 border-gray-200 text-lg text-gray-700">
                                            {{ $customer->email ?: 'N/A' }}
                                        </td>
                                        <td class="px-6 py-5 border-b-2 border-gray-200 text-lg text-gray-700">
                                            {{ $customer->phone ?: 'N/A' }}
                                        </td>
                                        <td class="px-6 py-5 border-b-2 border-gray-200">
                                            <div class="flex gap-3">
                                                <a href="{{ route('customers.show', $customer) }}"
                                                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-bold text-lg shadow-md transition-all">
                                                    View
                                                </a>
                                                <a href="{{ route('customers.edit', $customer) }}"
                                                   class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-bold text-lg shadow-md transition-all">
                                                    Edit
                                                </a>
                                                <form action="{{ route('customers.destroy', $customer) }}" method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this customer?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 font-bold text-lg shadow-md transition-all">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-xl text-gray-500">
                                            No customers found. <a href="{{ route('customers.create') }}" class="text-blue-600 hover:text-blue-800 font-bold">Add your first customer</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="md:hidden space-y-4" id="customerCards">
                        @forelse($customers as $customer)
                            <div class="customer-card border-3 border-gray-300 rounded-xl p-6 bg-gray-50 shadow-md"
                                 data-search="{{ strtolower($customer->customer_code . ' ' . $customer->name . ' ' . $customer->email . ' ' . $customer->phone) }}">
                                <div class="mb-4">
                                    <div class="text-sm font-semibold text-gray-600 mb-1">Customer Code</div>
                                    <div class="text-xl font-bold text-gray-900">{{ $customer->customer_code }}</div>
                                </div>
                                <div class="mb-4">
                                    <div class="text-sm font-semibold text-gray-600 mb-1">Name</div>
                                    <div class="text-xl font-bold text-gray-900">{{ $customer->name }}</div>
                                </div>
                                <div class="mb-4">
                                    <div class="text-sm font-semibold text-gray-600 mb-1">Email</div>
                                    <div class="text-lg text-gray-700">{{ $customer->email ?: 'N/A' }}</div>
                                </div>
                                <div class="mb-4">
                                    <div class="text-sm font-semibold text-gray-600 mb-1">Phone</div>
                                    <div class="text-lg text-gray-700">{{ $customer->phone ?: 'N/A' }}</div>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <a href="{{ route('customers.show', $customer) }}"
                                       class="bg-blue-600 text-white px-6 py-4 rounded-xl hover:bg-blue-700 font-bold text-xl text-center shadow-md transition-all">
                                        View
                                    </a>
                                    <a href="{{ route('customers.edit', $customer) }}"
                                       class="bg-green-600 text-white px-6 py-4 rounded-xl hover:bg-green-700 font-bold text-xl text-center shadow-md transition-all">
                                        Edit
                                    </a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full bg-red-600 text-white px-6 py-4 rounded-xl hover:bg-red-700 font-bold text-xl shadow-md transition-all">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <p class="text-xl text-gray-500 mb-6">No customers found.</p>
                                <a href="{{ route('customers.create') }}" class="inline-block bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700 font-bold text-xl shadow-lg">
                                    Add Your First Customer
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($customers->hasPages())
                        <div class="mt-8">
                            <div class="flex justify-center">
                                {{ $customers->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterCustomers() {
            const searchTerm = document.getElementById('customerSearch').value.toLowerCase();

            // Filter desktop table rows
            const rows = document.querySelectorAll('.customer-row');
            rows.forEach(row => {
                const searchData = row.getAttribute('data-search');
                if (searchData.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Filter mobile cards
            const cards = document.querySelectorAll('.customer-card');
            cards.forEach(card => {
                const searchData = card.getAttribute('data-search');
                if (searchData.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</x-app-layout>
