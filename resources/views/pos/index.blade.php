<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Point of Sale') }}
        </h2>
    </x-slot>

    <div class="py-2 sm:py-6">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <!-- Mobile Cart Toggle Button -->
            <div class="lg:hidden mb-4">
                <button onclick="toggleMobileCart()" class="w-full bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 font-semibold flex items-center justify-between">
                    <span>View Cart</span>
                    <span id="cartCount" class="bg-white text-blue-500 px-3 py-1 rounded-full">0</span>
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
                <!-- Products Section -->
                <div class="lg:col-span-2" id="productsSection">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-3 sm:p-6">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Products</h3>

                            <!-- Product Search -->
                            <div class="mb-3 sm:mb-4">
                                <input type="text" id="productSearch" placeholder="Search products..." class="w-full px-3 py-2 text-sm sm:text-base border rounded-lg">
                            </div>

                            <!-- Category Tabs -->
                            <div class="flex flex-wrap gap-1 sm:gap-2 mb-3 sm:mb-4 overflow-x-auto">
                                <button onclick="filterCategory('all')" class="category-btn px-2 sm:px-4 py-1 sm:py-2 text-xs sm:text-sm bg-blue-500 text-white rounded hover:bg-blue-600 whitespace-nowrap">All</button>
                                @foreach($categories as $category)
                                    <button onclick="filterCategory('{{ $category->id }}')" class="category-btn px-2 sm:px-4 py-1 sm:py-2 text-xs sm:text-sm bg-gray-200 rounded hover:bg-gray-300 whitespace-nowrap">
                                        {{ $category->name }}
                                    </button>
                                @endforeach
                            </div>

                            <!-- Products Grid -->
                            <div id="productsGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 gap-2 sm:gap-4 max-h-[400px] sm:max-h-96 overflow-y-auto">
                                @foreach($categories as $category)
                                    @foreach($category->products as $product)
                                        @if($product->stock_quantity > 0)
                                            <div class="product-item border rounded-lg p-2 sm:p-4 cursor-pointer hover:bg-gray-50 active:bg-gray-100"
                                                 data-category="{{ $category->id }}"
                                                 onclick='addToCart(@json($product))'>
                                                <div class="font-semibold text-xs sm:text-sm truncate">{{ $product->name }}</div>
                                                <div class="text-xs text-gray-600 hidden sm:block">{{ $product->sku }}</div>
                                                <div class="text-sm sm:text-lg font-bold text-blue-600">${{ number_format($product->price, 2) }}</div>
                                                <div class="text-xs text-gray-500">Stock: {{ $product->stock_quantity }}</div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Section -->
                <div class="lg:col-span-1 fixed inset-0 lg:relative bg-white lg:bg-transparent z-50 hidden lg:block" id="cartSection">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full lg:sticky lg:top-6">
                        <div class="p-3 sm:p-6 h-full flex flex-col">
                            <div class="flex justify-between items-center mb-3 sm:mb-4">
                                <h3 class="text-base sm:text-lg font-semibold">Cart</h3>
                                <button onclick="toggleMobileCart()" class="lg:hidden text-gray-500 hover:text-gray-700">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <div id="cartItems" class="space-y-2 mb-4 flex-1 overflow-y-auto"></div>

                            <div class="border-t pt-3 sm:pt-4 space-y-2">
                                <div class="flex justify-between text-sm sm:text-base">
                                    <span>Subtotal:</span>
                                    <span id="subtotal">$0.00</span>
                                </div>
                                <div class="flex justify-between text-sm sm:text-base">
                                    <span>Tax:</span>
                                    <input type="number" id="tax" value="0" step="0.01" min="0" class="w-20 sm:w-24 px-2 py-1 text-sm border rounded text-right" onchange="updateTotals()">
                                </div>
                                <div class="flex justify-between text-sm sm:text-base">
                                    <span>Discount:</span>
                                    <input type="number" id="discount" value="0" step="0.01" min="0" class="w-20 sm:w-24 px-2 py-1 text-sm border rounded text-right" onchange="updateTotals()">
                                </div>
                                <div class="flex justify-between text-lg sm:text-xl font-bold">
                                    <span>Total:</span>
                                    <span id="total">$0.00</span>
                                </div>
                            </div>

                            <div class="mt-3 sm:mt-4">
                                <label class="block text-xs sm:text-sm font-medium mb-2">Payment Method:</label>
                                <select id="paymentMethod" class="w-full px-2 sm:px-3 py-2 text-sm border rounded">
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>

                            <div class="mt-3 sm:mt-4">
                                <label class="block text-xs sm:text-sm font-medium mb-2">Notes (Optional):</label>
                                <textarea id="notes" class="w-full px-2 sm:px-3 py-2 text-sm border rounded" rows="2"></textarea>
                            </div>

                            <div class="mt-3 sm:mt-4 space-y-2">
                                <button onclick="processSale()" class="w-full bg-green-500 text-white px-4 py-2 sm:py-3 rounded-lg hover:bg-green-600 font-semibold text-sm sm:text-base">
                                    Complete Sale
                                </button>
                                <button onclick="clearCart()" class="w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 text-sm sm:text-base">
                                    Clear Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];

        function toggleMobileCart() {
            const cartSection = document.getElementById('cartSection');
            const productsSection = document.getElementById('productsSection');

            if (cartSection.classList.contains('hidden')) {
                cartSection.classList.remove('hidden');
                if (window.innerWidth < 1024) {
                    productsSection.classList.add('hidden');
                }
            } else {
                cartSection.classList.add('hidden');
                if (window.innerWidth < 1024) {
                    productsSection.classList.remove('hidden');
                }
            }
        }

        function updateCartCount() {
            const count = cart.reduce((sum, item) => sum + item.quantity, 0);
            const cartCount = document.getElementById('cartCount');
            if (cartCount) {
                cartCount.textContent = count;
            }
        }

        function addToCart(product) {
            const existingItem = cart.find(item => item.product_id === product.id);

            if (existingItem) {
                if (existingItem.quantity < product.stock_quantity) {
                    existingItem.quantity++;
                } else {
                    alert('Not enough stock');
                    return;
                }
            } else {
                cart.push({
                    product_id: product.id,
                    name: product.name,
                    price: parseFloat(product.price),
                    quantity: 1,
                    stock: product.stock_quantity
                });
            }

            renderCart();
        }

        function updateQuantity(index, newQuantity) {
            if (newQuantity <= 0) {
                cart.splice(index, 1);
            } else if (newQuantity <= cart[index].stock) {
                cart[index].quantity = newQuantity;
            } else {
                alert('Not enough stock');
                return;
            }
            renderCart();
        }

        function removeItem(index) {
            cart.splice(index, 1);
            renderCart();
        }

        function renderCart() {
            const cartItems = document.getElementById('cartItems');

            if (cart.length === 0) {
                cartItems.innerHTML = '<p class="text-gray-500 text-center text-sm sm:text-base">Cart is empty</p>';
            } else {
                cartItems.innerHTML = cart.map((item, index) => `
                    <div class="flex justify-between items-center border-b pb-2">
                        <div class="flex-1 min-w-0 pr-2">
                            <div class="font-semibold text-xs sm:text-sm truncate">${item.name}</div>
                            <div class="text-xs sm:text-sm text-gray-600">$${item.price.toFixed(2)} x ${item.quantity}</div>
                        </div>
                        <div class="flex items-center gap-1 sm:gap-2">
                            <button onclick="updateQuantity(${index}, ${item.quantity - 1})" class="px-1 sm:px-2 py-1 bg-gray-200 rounded text-sm">-</button>
                            <span class="text-sm">${item.quantity}</span>
                            <button onclick="updateQuantity(${index}, ${item.quantity + 1})" class="px-1 sm:px-2 py-1 bg-gray-200 rounded text-sm">+</button>
                            <button onclick="removeItem(${index})" class="px-1 sm:px-2 py-1 bg-red-500 text-white rounded text-sm">×</button>
                        </div>
                    </div>
                `).join('');
            }

            updateTotals();
            updateCartCount();
        }

        function updateTotals() {
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const tax = parseFloat(document.getElementById('tax').value) || 0;
            const discount = parseFloat(document.getElementById('discount').value) || 0;
            const total = subtotal + tax - discount;

            document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('total').textContent = '$' + total.toFixed(2);
        }

        function clearCart() {
            if (confirm('Are you sure you want to clear the cart?')) {
                cart = [];
                renderCart();
            }
        }

        async function processSale() {
            if (cart.length === 0) {
                alert('Cart is empty');
                return;
            }

            const items = cart.map(item => ({
                product_id: item.product_id,
                quantity: item.quantity,
                price: item.price
            }));

            const data = {
                items: items,
                payment_method: document.getElementById('paymentMethod').value,
                tax: parseFloat(document.getElementById('tax').value) || 0,
                discount: parseFloat(document.getElementById('discount').value) || 0,
                notes: document.getElementById('notes').value
            };

            try {
                const response = await fetch('{{ route("pos.process-sale") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    alert('Sale completed successfully! Invoice: ' + result.invoice_number);
                    window.open('/sales/' + result.sale_id + '/invoice', '_blank');
                    clearCart();
                    cart = [];
                    renderCart();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Error processing sale: ' + error.message);
            }
        }

        function filterCategory(categoryId) {
            const products = document.querySelectorAll('.product-item');

            products.forEach(product => {
                if (categoryId === 'all' || product.dataset.category === categoryId) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });

            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('bg-blue-500', 'text-white');
                btn.classList.add('bg-gray-200');
            });
            event.target.classList.add('bg-blue-500', 'text-white');
            event.target.classList.remove('bg-gray-200');
        }

        // Product search
        document.getElementById('productSearch').addEventListener('input', function(e) {
            const search = e.target.value.toLowerCase();
            const products = document.querySelectorAll('.product-item');

            products.forEach(product => {
                const text = product.textContent.toLowerCase();
                product.style.display = text.includes(search) ? 'block' : 'none';
            });
        });

        // Initialize
        renderCart();
    </script>
</x-app-layout>
