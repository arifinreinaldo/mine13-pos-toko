<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user
        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@pos.test',
            'password' => bcrypt('password'),
        ]);

        // Create categories
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and accessories'],
            ['name' => 'Clothing', 'description' => 'Apparel and fashion items'],
            ['name' => 'Food & Beverages', 'description' => 'Food items and drinks'],
            ['name' => 'Home & Garden', 'description' => 'Home improvement and garden supplies'],
            ['name' => 'Sports', 'description' => 'Sports equipment and accessories'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create products
        $products = [
            // Electronics
            ['category_id' => 1, 'name' => 'Wireless Mouse', 'sku' => 'ELEC-001', 'price' => 25.99, 'cost' => 15.00, 'stock_quantity' => 50, 'minimum_stock' => 10],
            ['category_id' => 1, 'name' => 'USB Cable', 'sku' => 'ELEC-002', 'price' => 9.99, 'cost' => 5.00, 'stock_quantity' => 100, 'minimum_stock' => 20],
            ['category_id' => 1, 'name' => 'Bluetooth Speaker', 'sku' => 'ELEC-003', 'price' => 49.99, 'cost' => 30.00, 'stock_quantity' => 30, 'minimum_stock' => 5],
            ['category_id' => 1, 'name' => 'Phone Charger', 'sku' => 'ELEC-004', 'price' => 19.99, 'cost' => 10.00, 'stock_quantity' => 75, 'minimum_stock' => 15],

            // Clothing
            ['category_id' => 2, 'name' => 'Cotton T-Shirt', 'sku' => 'CLO-001', 'price' => 15.99, 'cost' => 8.00, 'stock_quantity' => 60, 'minimum_stock' => 10],
            ['category_id' => 2, 'name' => 'Jeans', 'sku' => 'CLO-002', 'price' => 45.99, 'cost' => 25.00, 'stock_quantity' => 40, 'minimum_stock' => 8],
            ['category_id' => 2, 'name' => 'Baseball Cap', 'sku' => 'CLO-003', 'price' => 12.99, 'cost' => 6.00, 'stock_quantity' => 35, 'minimum_stock' => 10],

            // Food & Beverages
            ['category_id' => 3, 'name' => 'Bottled Water', 'sku' => 'FOOD-001', 'price' => 1.99, 'cost' => 0.50, 'stock_quantity' => 200, 'minimum_stock' => 50],
            ['category_id' => 3, 'name' => 'Energy Drink', 'sku' => 'FOOD-002', 'price' => 2.99, 'cost' => 1.50, 'stock_quantity' => 150, 'minimum_stock' => 30],
            ['category_id' => 3, 'name' => 'Protein Bar', 'sku' => 'FOOD-003', 'price' => 3.49, 'cost' => 2.00, 'stock_quantity' => 120, 'minimum_stock' => 25],

            // Home & Garden
            ['category_id' => 4, 'name' => 'LED Bulb', 'sku' => 'HOME-001', 'price' => 8.99, 'cost' => 4.00, 'stock_quantity' => 80, 'minimum_stock' => 15],
            ['category_id' => 4, 'name' => 'Garden Hose', 'sku' => 'HOME-002', 'price' => 29.99, 'cost' => 18.00, 'stock_quantity' => 25, 'minimum_stock' => 5],

            // Sports
            ['category_id' => 5, 'name' => 'Yoga Mat', 'sku' => 'SPORT-001', 'price' => 24.99, 'cost' => 12.00, 'stock_quantity' => 45, 'minimum_stock' => 10],
            ['category_id' => 5, 'name' => 'Resistance Bands', 'sku' => 'SPORT-002', 'price' => 18.99, 'cost' => 9.00, 'stock_quantity' => 55, 'minimum_stock' => 10],
            ['category_id' => 5, 'name' => 'Water Bottle', 'sku' => 'SPORT-003', 'price' => 12.99, 'cost' => 6.00, 'stock_quantity' => 70, 'minimum_stock' => 15],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create customers
        $customers = [
            ['name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '555-0101', 'address' => '123 Main St, City, State 12345', 'customer_code' => 'CUST-000001'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone' => '555-0102', 'address' => '456 Oak Ave, City, State 12345', 'customer_code' => 'CUST-000002'],
            ['name' => 'Bob Johnson', 'email' => 'bob@example.com', 'phone' => '555-0103', 'address' => '789 Pine Rd, City, State 12345', 'customer_code' => 'CUST-000003'],
            ['name' => 'Alice Brown', 'email' => 'alice@example.com', 'phone' => '555-0104', 'address' => '321 Elm St, City, State 12345', 'customer_code' => 'CUST-000004'],
            ['name' => 'Charlie Wilson', 'email' => 'charlie@example.com', 'phone' => '555-0105', 'address' => '654 Maple Dr, City, State 12345', 'customer_code' => 'CUST-000005'],
            ['name' => 'Walk-in Customer', 'email' => null, 'phone' => null, 'address' => null, 'customer_code' => 'CUST-000006'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        // Create settings
        $settings = [
            ['key' => 'company_name', 'value' => 'Demo POS Store'],
            ['key' => 'company_address', 'value' => '123 Business Ave, Suite 100, City, State 12345'],
            ['key' => 'company_phone', 'value' => '(555) 123-4567'],
            ['key' => 'company_email', 'value' => 'info@demopstore.com'],
            ['key' => 'invoice_header', 'value' => 'Demo POS Store - Your Trusted Retailer'],
            ['key' => 'invoice_footer', 'value' => 'Thank you for your business! Please visit us again.'],
            ['key' => 'tax_rate', 'value' => '8.5'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        $this->command->info('✓ Database seeded successfully!');
        $this->command->info('✓ Test user created: admin@pos.test / password');
        $this->command->info('✓ ' . count($categories) . ' categories created');
        $this->command->info('✓ ' . count($products) . ' products created');
        $this->command->info('✓ ' . count($customers) . ' customers created');
        $this->command->info('✓ Settings configured');
    }
}
