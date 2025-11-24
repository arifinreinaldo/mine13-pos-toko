# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

A comprehensive Point of Sale (POS) system built with Laravel 12, designed for retail stores with inventory management, sales tracking, and detailed reporting. The system is specifically optimized for accessibility and ease of use for all age groups, including older generation users, with large fonts (18-28px), high-contrast colors, and generous spacing.

## Development Commands

### Initial Setup
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
```

### Development
```bash
# Full development environment (server, queue, logs, vite)
composer dev

# Individual services
php artisan serve                # Start development server (http://localhost:8000)
php artisan queue:listen --tries=1  # Start queue worker
php artisan pail --timeout=0     # View logs in real-time
npm run dev                      # Start Vite dev server for assets
```

### Testing
```bash
composer test              # Run full test suite
php artisan test           # Run tests directly
php artisan test --filter=ExampleTest  # Run specific test
```

### Database
```bash
php artisan migrate        # Run migrations
php artisan migrate --seed # Run migrations and seed test data
php artisan migrate:fresh --seed  # Drop all tables, re-migrate, and seed
php artisan db:seed        # Seed database only
```

### Code Quality
```bash
vendor/bin/pint            # Run Laravel Pint code formatter
```

### Production
```bash
npm run build              # Build production assets
composer setup             # Run complete setup (install, key generation, migration, build)
```

## Architecture Overview

### Core System Design

This is a traditional Laravel MVC application with Blade templates, using Laravel Breeze for authentication. The system follows standard Laravel conventions with resource controllers and Eloquent models.

**Key architectural patterns:**
- Resource controllers for CRUD operations (Categories, Customers, Products, Sales)
- Database transactions for critical operations (sales processing)
- Automatic stock management via model events (stock decrements on sale)
- Settings stored as key-value pairs in database
- Invoice number generation with sequential numbering (INV-000001)

### Database Schema & Relationships

**Core Models:**
- `User` - System users (authenticated via Laravel Breeze)
- `Category` - Product categories
- `Customer` - Customer records with unique customer codes (CUST-000001)
- `Product` - Inventory items with cost, price, stock tracking
- `Sale` - Sales transactions (belongsTo User, Customer)
- `SaleItem` - Line items for sales (belongsTo Sale, Product)
- `Setting` - System configuration (key-value store)

**Key Relationships:**
- `Sale` → `SaleItem` (one-to-many)
- `Sale` → `Customer` (many-to-one, nullable for walk-in customers)
- `Sale` → `User` (many-to-one, tracks who processed the sale)
- `Product` → `Category` (many-to-one)
- `Product` → `SaleItem` (one-to-many)

**Stock Management:**
- Products have `stock_quantity` and `minimum_stock` fields
- Stock automatically decrements when sales are completed (POSController.php:75)
- Low stock alerts when `stock_quantity <= minimum_stock`
- Stock validation occurs before sale processing to prevent overselling

### Controllers & Routes

**Main Controllers:**
- `POSController` - Point of sale interface and sale processing (routes/web.php:41-42)
- `SaleController` - Sales history, details, invoice viewing/printing (routes/web.php:44-47)
- `ProductController` - Product CRUD, search API, low stock list (routes/web.php:37-39)
- `CustomerController` - Customer CRUD, search API (routes/web.php:34-35)
- `CategoryController` - Category CRUD (routes/web.php:32)
- `ReportController` - Sales and inventory reports (routes/web.php:49-50)
- `SettingController` - System configuration management (routes/web.php:52-53)

**Critical Business Logic:**
- Sale processing with transaction safety in `POSController::processSale()` (app/Http/Controllers/POSController.php:20-95)
  - Validates stock availability before processing
  - Creates Sale record with invoice number
  - Creates SaleItem records for each product
  - Decrements product stock quantities
  - Uses DB transactions to ensure data integrity
- Invoice number generation in `Sale::generateInvoiceNumber()` (app/Models/Sale.php:43-48)
- Low stock detection via `Product::isLowStock()` (app/Models/Product.php:36-39)

### Frontend Architecture

**Tech Stack:**
- Laravel Blade templates for views
- Tailwind CSS for styling (with custom large font sizes for accessibility)
- Alpine.js for interactive components
- Vite for asset bundling

**Key Views:**
- `resources/views/pos/index.blade.php` - Main POS interface (product grid, cart, checkout)
- `resources/views/sales/invoice.blade.php` - Invoice template for printing
- `resources/views/dashboard.blade.php` - Dashboard with stats and low stock alerts
- `resources/views/layouts/navigation.blade.php` - Main navigation bar

**Design System:**
- Extra large fonts: headers (28-42px), content (18-22px), buttons (20-24px)
- High contrast colors with 2-4px thick borders
- Large touch targets with 18-24px padding
- Mobile-responsive with simplified navigation
- Print-optimized invoice design (20-26px fonts)

### Database Seeding

The seeder (database/seeders/DatabaseSeeder.php) creates:
- 1 test user: admin@pos.test / password
- 5 product categories (Electronics, Clothing, Food & Beverages, Home & Garden, Sports)
- 15 sample products with varying stock levels
- 6 customers including a "Walk-in Customer" option
- Default system settings (company info, invoice templates, tax rate)

## Common Development Patterns

### Adding a New Product Feature
1. Update the `products` migration if new fields are needed
2. Add fields to `Product` model's `$fillable` array
3. Update ProductController methods (store, update)
4. Modify product form views to include new fields
5. Run migrations: `php artisan migrate`

### Modifying Sale Processing
All sale processing logic is in `POSController::processSale()`. This method:
- Validates request data (items, quantities, payment method)
- Checks stock availability
- Calculates subtotal, tax, discount, total
- Creates Sale and SaleItem records
- Decrements product stock
- Returns JSON response with sale ID and invoice number

Always wrap sale processing changes in the existing DB transaction block.

### Working with Settings
Settings are stored as key-value pairs. To add a new setting:
1. Add to seeder (database/seeders/DatabaseSeeder.php)
2. Update SettingController to handle the new setting
3. Update settings form view (resources/views/settings/index.blade.php)

Common settings keys: `company_name`, `company_address`, `company_phone`, `company_email`, `invoice_header`, `invoice_footer`, `tax_rate`

### Adding New Reports
Reports are handled in `ReportController`. Current reports:
- Sales report with date filtering
- Inventory report with stock levels

Add new report methods to ReportController and create corresponding views in `resources/views/reports/`.

## Accessibility Requirements

This system is designed with accessibility as a core principle. When making changes:
- Maintain large font sizes (minimum 18px for body text)
- Keep high contrast ratios between text and backgrounds
- Use thick borders (2-4px) for visual separation
- Provide generous padding/spacing (minimum 18px for buttons)
- Ensure touch targets are large (minimum 14x14 units)
- Test on mobile devices to verify touch interactions work well

## Testing Credentials

After running `php artisan migrate --seed`:
- Email: admin@pos.test
- Password: password

## Important Notes

- The system uses MySQL in production but SQLite in-memory for testing
- Authentication is handled by Laravel Breeze (standard session-based auth)
- Invoice numbers are generated sequentially and must remain unique
- Stock quantities must never go negative (validation in POSController)
- Customer selection is optional in POS (defaults to walk-in customer if not specified)
- All monetary values are stored as decimals with 2 decimal places
