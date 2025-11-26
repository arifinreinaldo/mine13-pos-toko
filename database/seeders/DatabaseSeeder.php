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
            ['name' => 'Oli & Pelumas', 'description' => 'Oli mesin, oli transmisi, dan pelumas'],
            ['name' => 'Filter', 'description' => 'Filter oli, filter udara, filter bahan bakar'],
            ['name' => 'Rem', 'description' => 'Kampas rem, minyak rem, dan komponen rem'],
            ['name' => 'Aki & Kelistrikan', 'description' => 'Aki, busi, kabel, dan komponen kelistrikan'],
            ['name' => 'Ban & Velg', 'description' => 'Ban motor, ban mobil, dan velg'],
            ['name' => 'Lampu', 'description' => 'Lampu depan, lampu belakang, dan lampu sein'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create products (Indonesian spare parts with Rupiah pricing)
        $products = [
            // Oli & Pelumas
            ['category_id' => 1, 'name' => 'Oli Mesin Mobil 10W-40 (4L)', 'sku' => 'OLI-001', 'price' => 185000, 'cost' => 145000, 'stock_quantity' => 50, 'minimum_stock' => 10],
            ['category_id' => 1, 'name' => 'Oli Motor Matic 800ml', 'sku' => 'OLI-002', 'price' => 42000, 'cost' => 32000, 'stock_quantity' => 100, 'minimum_stock' => 20],
            ['category_id' => 1, 'name' => 'Oli Transmisi ATF (1L)', 'sku' => 'OLI-003', 'price' => 95000, 'cost' => 75000, 'stock_quantity' => 30, 'minimum_stock' => 8],
            ['category_id' => 1, 'name' => 'Oli Gardan SAE 90 (1L)', 'sku' => 'OLI-004', 'price' => 65000, 'cost' => 50000, 'stock_quantity' => 25, 'minimum_stock' => 5],
            ['category_id' => 1, 'name' => 'Gemuk/Grease (500g)', 'sku' => 'OLI-005', 'price' => 35000, 'cost' => 25000, 'stock_quantity' => 40, 'minimum_stock' => 10],

            // Filter
            ['category_id' => 2, 'name' => 'Filter Oli Mobil', 'sku' => 'FIL-001', 'price' => 45000, 'cost' => 32000, 'stock_quantity' => 80, 'minimum_stock' => 15],
            ['category_id' => 2, 'name' => 'Filter Udara Mobil', 'sku' => 'FIL-002', 'price' => 85000, 'cost' => 65000, 'stock_quantity' => 60, 'minimum_stock' => 12],
            ['category_id' => 2, 'name' => 'Filter Oli Motor', 'sku' => 'FIL-003', 'price' => 25000, 'cost' => 18000, 'stock_quantity' => 120, 'minimum_stock' => 25],
            ['category_id' => 2, 'name' => 'Filter Udara Motor', 'sku' => 'FIL-004', 'price' => 35000, 'cost' => 25000, 'stock_quantity' => 90, 'minimum_stock' => 20],
            ['category_id' => 2, 'name' => 'Filter Bensin', 'sku' => 'FIL-005', 'price' => 55000, 'cost' => 40000, 'stock_quantity' => 50, 'minimum_stock' => 10],

            // Rem
            ['category_id' => 3, 'name' => 'Kampas Rem Depan Mobil', 'sku' => 'REM-001', 'price' => 285000, 'cost' => 220000, 'stock_quantity' => 35, 'minimum_stock' => 8],
            ['category_id' => 3, 'name' => 'Kampas Rem Belakang Mobil', 'sku' => 'REM-002', 'price' => 245000, 'cost' => 190000, 'stock_quantity' => 30, 'minimum_stock' => 8],
            ['category_id' => 3, 'name' => 'Kampas Rem Motor', 'sku' => 'REM-003', 'price' => 45000, 'cost' => 32000, 'stock_quantity' => 100, 'minimum_stock' => 20],
            ['category_id' => 3, 'name' => 'Minyak Rem DOT 3 (300ml)', 'sku' => 'REM-004', 'price' => 28000, 'cost' => 20000, 'stock_quantity' => 70, 'minimum_stock' => 15],
            ['category_id' => 3, 'name' => 'Disc Brake/Cakram Depan', 'sku' => 'REM-005', 'price' => 385000, 'cost' => 295000, 'stock_quantity' => 20, 'minimum_stock' => 5],

            // Aki & Kelistrikan
            ['category_id' => 4, 'name' => 'Aki Mobil 45Ah', 'sku' => 'AKI-001', 'price' => 785000, 'cost' => 625000, 'stock_quantity' => 25, 'minimum_stock' => 5],
            ['category_id' => 4, 'name' => 'Aki Motor 5Ah', 'sku' => 'AKI-002', 'price' => 185000, 'cost' => 145000, 'stock_quantity' => 40, 'minimum_stock' => 8],
            ['category_id' => 4, 'name' => 'Busi Mobil Iridium', 'sku' => 'AKI-003', 'price' => 95000, 'cost' => 72000, 'stock_quantity' => 80, 'minimum_stock' => 16],
            ['category_id' => 4, 'name' => 'Busi Motor Standar', 'sku' => 'AKI-004', 'price' => 18000, 'cost' => 12000, 'stock_quantity' => 150, 'minimum_stock' => 30],
            ['category_id' => 4, 'name' => 'Kabel Busi Set', 'sku' => 'AKI-005', 'price' => 145000, 'cost' => 110000, 'stock_quantity' => 35, 'minimum_stock' => 8],

            // Ban & Velg
            ['category_id' => 5, 'name' => 'Ban Motor Tubeless 80/90-14', 'sku' => 'BAN-001', 'price' => 285000, 'cost' => 225000, 'stock_quantity' => 45, 'minimum_stock' => 10],
            ['category_id' => 5, 'name' => 'Ban Motor Tubeless 90/80-14', 'sku' => 'BAN-002', 'price' => 325000, 'cost' => 260000, 'stock_quantity' => 40, 'minimum_stock' => 10],
            ['category_id' => 5, 'name' => 'Ban Mobil 185/65 R15', 'sku' => 'BAN-003', 'price' => 685000, 'cost' => 545000, 'stock_quantity' => 30, 'minimum_stock' => 8],
            ['category_id' => 5, 'name' => 'Ban Dalam Motor', 'sku' => 'BAN-004', 'price' => 35000, 'cost' => 25000, 'stock_quantity' => 80, 'minimum_stock' => 20],
            ['category_id' => 5, 'name' => 'Velg Racing 14 inch', 'sku' => 'BAN-005', 'price' => 485000, 'cost' => 385000, 'stock_quantity' => 20, 'minimum_stock' => 5],

            // Lampu
            ['category_id' => 6, 'name' => 'Lampu Depan LED Motor', 'sku' => 'LMP-001', 'price' => 125000, 'cost' => 95000, 'stock_quantity' => 60, 'minimum_stock' => 12],
            ['category_id' => 6, 'name' => 'Lampu Depan Halogen Mobil', 'sku' => 'LMP-002', 'price' => 85000, 'cost' => 65000, 'stock_quantity' => 70, 'minimum_stock' => 15],
            ['category_id' => 6, 'name' => 'Lampu Sein Motor (Set)', 'sku' => 'LMP-003', 'price' => 45000, 'cost' => 32000, 'stock_quantity' => 90, 'minimum_stock' => 18],
            ['category_id' => 6, 'name' => 'Lampu Rem LED', 'sku' => 'LMP-004', 'price' => 65000, 'cost' => 48000, 'stock_quantity' => 75, 'minimum_stock' => 15],
            ['category_id' => 6, 'name' => 'Lampu HID Kit Mobil', 'sku' => 'LMP-005', 'price' => 485000, 'cost' => 375000, 'stock_quantity' => 25, 'minimum_stock' => 5],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create customers
        $customers = [
            ['name' => 'Budi Santoso', 'email' => 'budi@example.com', 'phone' => '081234567890', 'address' => 'Jl. Sudirman No. 123, Jakarta Pusat', 'customer_code' => 'CUST-000001'],
            ['name' => 'Siti Rahayu', 'email' => 'siti@example.com', 'phone' => '081234567891', 'address' => 'Jl. Gatot Subroto No. 45, Jakarta Selatan', 'customer_code' => 'CUST-000002'],
            ['name' => 'Ahmad Wijaya', 'email' => 'ahmad@example.com', 'phone' => '081234567892', 'address' => 'Jl. Thamrin No. 78, Jakarta Pusat', 'customer_code' => 'CUST-000003'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@example.com', 'phone' => '081234567893', 'address' => 'Jl. Kuningan No. 56, Jakarta Selatan', 'customer_code' => 'CUST-000004'],
            ['name' => 'Rudi Hartono', 'email' => 'rudi@example.com', 'phone' => '081234567894', 'address' => 'Jl. Rasuna Said No. 89, Jakarta Selatan', 'customer_code' => 'CUST-000005'],
            ['name' => 'Pelanggan Umum', 'email' => null, 'phone' => null, 'address' => null, 'customer_code' => 'CUST-000006'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        // Create settings
        $settings = [
            ['key' => 'company_name', 'value' => 'Toko Sparepart Motor & Mobil'],
            ['key' => 'company_address', 'value' => 'Jl. Raya Otomotif No. 88, Jakarta Timur 13450'],
            ['key' => 'company_phone', 'value' => '(021) 8765-4321'],
            ['key' => 'company_email', 'value' => 'info@tokosparepart.com'],
            ['key' => 'invoice_header', 'value' => 'Toko Sparepart Motor & Mobil - Sparepart Berkualitas'],
            ['key' => 'invoice_footer', 'value' => 'Terima kasih atas kepercayaan Anda! Silakan datang kembali.'],
            ['key' => 'tax_rate', 'value' => '11'],
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
