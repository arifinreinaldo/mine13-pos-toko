<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Point of Sale') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Mobile Cart Toggle Button -->
            <div class="lg:hidden mb-6">
                <button onclick="toggleMobileCart()" class="w-full bg-blue-600 text-white px-6 py-5 rounded-xl hover:bg-blue-700 font-bold text-2xl flex items-center justify-between shadow-lg">
                    <span>View Cart</span>
                    <span id="cartCount" class="bg-white text-blue-600 px-5 py-2 rounded-full text-xl font-bold">0</span>
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Products Section -->
                <div class="lg:col-span-2" id="productsSection">
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200">
                        <div class="p-6 sm:p-8">
                            <h3 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800">Select Products</h3>

                            <!-- Product Search -->
                            <div class="mb-6">
                                <label class="block text-xl font-semibold mb-3 text-gray-700">Search:</label>
                                <input type="text" id="productSearch" placeholder="Type product name..." class="w-full px-6 py-5 text-2xl border-3 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500">
                            </div>

                            <!-- Category Tabs -->
                            <div class="mb-6">
                                <label class="block text-xl font-semibold mb-3 text-gray-700">Category:</label>
                                <div class="flex flex-wrap gap-3 overflow-x-auto pb-2">
                                    <button onclick="filterCategory('all')" class="category-btn px-8 py-4 text-xl font-bold bg-blue-600 text-white rounded-xl hover:bg-blue-700 whitespace-nowrap shadow-md">All Products</button>
                                    @foreach($categories as $category)
                                        <button onclick="filterCategory('{{ $category->id }}')" class="category-btn px-8 py-4 text-xl font-semibold bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300 whitespace-nowrap shadow-md">
                                            {{ $category->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Products Grid -->
                            <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[500px] overflow-y-auto pr-2">
                                @foreach($categories as $category)
                                    @foreach($category->products as $product)
                                        @if($product->stock_quantity > 0)
                                            <div class="product-item border-3 border-gray-300 rounded-xl p-6 cursor-pointer hover:bg-blue-50 hover:border-blue-500 active:bg-blue-100 shadow-md transition-all"
                                                 data-category="{{ $category->id }}"
                                                 onclick='addToCart(@json($product))'>
                                                <div class="font-bold text-xl mb-2 text-gray-800">{{ $product->name }}</div>
                                                <div class="text-3xl font-bold text-blue-600 mb-2">{{ format_currency($product->price) }}</div>
                                                <div class="text-lg text-gray-600">Stock: {{ $product->stock_quantity }} available</div>
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
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border-2 border-gray-200 h-full lg:sticky lg:top-6">
                        <div class="p-6 sm:p-8 h-full flex flex-col">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-2xl sm:text-3xl font-bold text-gray-800">Shopping Cart</h3>
                                <button onclick="toggleMobileCart()" class="lg:hidden text-gray-600 hover:text-gray-800">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <div id="cartItems" class="space-y-4 mb-6 flex-1 overflow-y-auto"></div>

                            <div class="border-t-4 border-gray-300 pt-6 space-y-4">
                                <div class="flex justify-between text-xl font-semibold">
                                    <span class="text-gray-700">Subtotal:</span>
                                    <span id="subtotal" class="text-gray-900">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center text-xl">
                                    <span class="text-gray-700 font-semibold">Tax (Rp):</span>
                                    <input type="number" id="tax" value="0" step="100" min="0" class="w-32 px-4 py-3 text-xl font-semibold border-2 border-gray-300 rounded-lg text-right focus:ring-4 focus:ring-blue-300 focus:border-blue-500" onchange="updateTotals()">
                                </div>
                                <div class="flex justify-between items-center text-xl">
                                    <span class="text-gray-700 font-semibold">Discount (Rp):</span>
                                    <input type="number" id="discount" value="0" step="100" min="0" class="w-32 px-4 py-3 text-xl font-semibold border-2 border-gray-300 rounded-lg text-right focus:ring-4 focus:ring-blue-300 focus:border-blue-500" onchange="updateTotals()">
                                </div>
                                <div class="flex justify-between text-3xl font-bold bg-blue-50 p-4 rounded-xl">
                                    <span class="text-gray-800">TOTAL:</span>
                                    <span id="total" class="text-blue-600">Rp 0</span>
                                </div>
                            </div>

                            <div class="mt-5">
                                <label class="block text-xl font-bold mb-3 text-gray-700">Customer:</label>
                                <select id="customerId" class="w-full px-5 py-4 text-xl font-semibold border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500">
                                    <option value="">Walk-in Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-5">
                                <label class="block text-xl font-bold mb-3 text-gray-700">Payment Method:</label>
                                <select id="paymentMethod" class="w-full px-5 py-4 text-xl font-semibold border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500">
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="transfer">Bank Transfer</option>
                                </select>
                            </div>

                            <div class="mt-5">
                                <label class="block text-xl font-bold mb-3 text-gray-700">Notes (Optional):</label>
                                <textarea id="notes" class="w-full px-5 py-4 text-xl border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500" rows="2"></textarea>
                            </div>

                            <div class="mt-6 space-y-4">
                                <button onclick="processSale()" class="w-full bg-green-600 text-white px-6 py-6 rounded-xl hover:bg-green-700 font-bold text-2xl shadow-lg hover:shadow-xl transition-all">
                                    ✓ COMPLETE SALE
                                </button>
                                <button onclick="clearCart()" class="w-full bg-red-600 text-white px-6 py-5 rounded-xl hover:bg-red-700 font-bold text-xl shadow-lg hover:shadow-xl transition-all">
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
        // Currency formatter
        const formatCurrency = (amount) => {
            return 'Rp ' + new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
        };

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
                    alert('⚠️ NOT ENOUGH STOCK\n\nOnly ' + product.stock_quantity + ' items available.');
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
                alert('⚠️ NOT ENOUGH STOCK\n\nOnly ' + cart[index].stock + ' items available.');
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
                cartItems.innerHTML = '<p class="text-gray-500 text-center text-2xl py-8">Cart is empty</p>';
            } else {
                cartItems.innerHTML = cart.map((item, index) => `
                    <div class="border-2 border-gray-300 rounded-xl p-5 bg-gray-50 shadow-md">
                        <div class="mb-3">
                            <div class="font-bold text-xl mb-2 text-gray-800">${item.name}</div>
                            <div class="text-lg text-gray-600">${formatCurrency(item.price)} each</div>
                            <div class="text-2xl font-bold text-blue-600 mt-1">Total: ${formatCurrency(item.price * item.quantity)}</div>
                        </div>
                        <div class="flex items-center justify-between gap-3 mt-4">
                            <div class="flex items-center gap-3 bg-white border-2 border-gray-300 rounded-lg p-2">
                                <button onclick="updateQuantity(${index}, ${item.quantity - 1})" class="px-5 py-3 bg-gray-200 hover:bg-gray-300 rounded-lg text-2xl font-bold w-14 h-14 flex items-center justify-center">−</button>
                                <span class="text-2xl font-bold min-w-[3rem] text-center">${item.quantity}</span>
                                <button onclick="updateQuantity(${index}, ${item.quantity + 1})" class="px-5 py-3 bg-gray-200 hover:bg-gray-300 rounded-lg text-2xl font-bold w-14 h-14 flex items-center justify-center">+</button>
                            </div>
                            <button onclick="removeItem(${index})" class="px-6 py-4 bg-red-600 text-white rounded-lg hover:bg-red-700 text-xl font-bold shadow-md">Remove</button>
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

            document.getElementById('subtotal').textContent = formatCurrency(subtotal);
            document.getElementById('total').textContent = formatCurrency(total);
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

            const customerId = document.getElementById('customerId').value;
            const data = {
                items: items,
                customer_id: customerId || null,
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
