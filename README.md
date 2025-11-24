# Laravel POS System

A comprehensive Point of Sale (POS) system built with Laravel 12, designed for retail stores with inventory management, sales tracking, and detailed reporting. **Optimized for accessibility and ease of use for all age groups, including older generation users.**

## Features

### Core Functionality
- **Point of Sale Interface**: Modern, intuitive, mobile-friendly POS interface for processing sales
  - **Accessibility-First Design**: Large fonts (18-28px), high-contrast colors, and generous spacing
  - **Senior-Friendly UI**: Extra-large buttons, clear labels, and simplified navigation
  - **Touch-Optimized**: Large touch targets (minimum 14x14 size) for easy interaction
- **Customer Management**: Track customer information and purchase history
- **Inventory Management**: Track stock levels with automatic updates after sales
- **Product Management**: Full CRUD operations for products with categories
- **Sales Management**: Complete sales history with detailed transaction records
- **Invoice Printing**: Customizable invoice templates with customer information and print functionality (20-26px font sizes)
- **Low Stock Alerts**: Automatic notifications when products reach minimum stock levels

### Reporting
- **Sales Reports**: Detailed sales analytics with date filtering
- **Inventory Reports**: Comprehensive inventory insights
- Tax and discount tracking
- Profit calculations

### Settings & Configuration
- **Invoice Configuration**: Customizable invoice header and footer
- **Company Information**: Configure company details for invoices
- **Tax Management**: Set default tax rates

## UI/UX Design Principles

This POS system has been specifically designed with **accessibility and ease of use** in mind, particularly for older generation users who may need larger, clearer interfaces.

### Key Design Features:

#### Typography & Readability
- **Large Font Sizes**:
  - Page headers: 28-42px
  - Main content: 18-22px
  - Buttons and labels: 20-24px
  - Cart items and totals: 22-26px
- **High Line Height**: 1.6 spacing for improved readability
- **Bold Text**: Important information uses bold fonts for emphasis

#### Buttons & Interactive Elements
- **Extra Large Buttons**: Minimum padding of 18-24px for easy clicking/tapping
- **Clear Visual Feedback**: Hover states with color changes and shadows
- **Large Touch Targets**: All interactive elements sized for easy interaction
- **Simple Icons**: Large, recognizable icons (🛒, ➕, 📊, ⚠️, ✓)

#### Visual Design
- **High Contrast**: Strong contrast between text and backgrounds
- **Thick Borders**: 2-4px borders for better visual separation
- **Generous Spacing**: Extra padding and margins between elements
- **Clear Sections**: Well-defined sections with colored backgrounds
- **Simplified Colors**: Blue for primary actions, green for success, red for warnings/remove

#### Navigation & Layout
- **Taller Navigation Bar**: 80px height for easier clicking
- **Larger Navigation Links**: 18-20px font with bold weight
- **Simplified Mobile Menu**: Large, well-spaced menu items
- **Clear Labels**: Descriptive, straightforward labels (e.g., "COMPLETE SALE", "Shopping Cart")

#### POS Interface Specific
- **Large Product Cards**: Ample padding (24-32px) with clear product info
- **Big Category Buttons**: 32-40px padding for easy category switching
- **Prominent Cart Items**: Each cart item in a bordered card with large quantity controls
- **Clear Totals Display**: 40-52px font for the final total amount
- **Visual Separation**: Cart items separated with borders and background colors

#### Invoice Design
- **Print-Friendly**: Optimized 20-26px fonts for easy reading when printed
- **Clear Hierarchy**: Section headings at 26-28px
- **Highlighted Totals**: Bold, large total amounts for quick scanning
- **Organized Sections**: Customer info, items, and totals clearly separated

### Accessibility Benefits:
- ✅ Easier to read for users with vision impairments
- ✅ Larger touch targets reduce errors on mobile/tablet devices
- ✅ Clear visual hierarchy helps users understand the interface quickly
- ✅ High contrast improves usability in various lighting conditions
- ✅ Simplified design reduces cognitive load for all users

## Installation

### Prerequisites
- PHP 8.4 or higher
- Composer
- MySQL database
- Node.js & NPM

### Setup Instructions

1. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database setup**
   - Create a MySQL database
   - Update `.env` file with database credentials:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=pos_system
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

4. **Run migrations and seed test data**
   ```bash
   php artisan migrate --seed
   ```
   This will create all necessary database tables and populate them with sample data for testing.

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

7. **Access the application**
   - URL: http://localhost:8000
   - Test credentials (created by seeder):
     - Email: `admin@pos.test`
     - Password: `password`

## Usage Guide

### Initial Setup
1. Login with your account (or use test account: admin@pos.test / password)
2. Configure company information in **Settings**
3. Add **Categories** for your products (or use seeded data)
4. Add **Customers** to track purchases
5. Add **Products** with stock information (or use seeded data)

### Making a Sale
1. Navigate to **POS** from the menu
2. Browse products by category or use search
3. Click products to add them to cart
4. Select a customer (optional - defaults to "Walk-in Customer")
5. Adjust quantities using +/- buttons
6. Add tax and discount if applicable
7. Select payment method
8. Click "Complete Sale"
9. Print the generated invoice

### Managing Customers
- Add/edit customers from **Customers** menu
- View customer purchase history
- Track customer information (name, email, phone, address)
- Each customer has a unique customer code

### Managing Inventory
- Add/edit products from **Products** menu
- Monitor stock levels
- View low stock alerts on dashboard
- Stock automatically decreases when sales are made

### Mobile Usage
- On mobile devices, use the "View Cart" button to toggle between products and cart
- All features are optimized for touch interactions

## Key Features

- **Dashboard**: Quick overview with sales metrics
- **POS System**: Real-time product search and cart management
- **Reports**: Sales and inventory analytics
- **Invoice System**: Configurable templates with print support
- **Settings**: Company and invoice configuration

## Testing the System

### Pre-deployment Testing Checklist

The system includes a comprehensive database seeder with test data. After running `php artisan migrate --seed`, you'll have:

- **1 Test User**: admin@pos.test / password
- **5 Categories**: Electronics, Clothing, Food & Beverages, Home & Garden, Sports
- **15 Products**: Various products with different stock levels
- **6 Customers**: Including a "Walk-in Customer" option
- **Configured Settings**: Company information and invoice templates

### Test Scenarios

#### 1. Test User Authentication
```bash
# Login with test credentials
Email: admin@pos.test
Password: password
```

#### 2. Test Dashboard
- View product count
- Check low stock alerts
- Verify today's sales metrics

#### 3. Test Product Management
- Create a new product
- Edit existing product
- Update stock quantities
- Delete a product
- View low stock products

#### 4. Test Customer Management
- Create a new customer
- View customer list
- Edit customer information
- View customer purchase history

#### 5. Test POS System (Critical)
- Add products to cart
- Select a customer (optional)
- Apply tax and discounts
- Complete a sale with different payment methods
- Verify stock is automatically reduced
- Print invoice with customer information

#### 6. Test Sales Management
- View sales history
- View individual sale details
- Print/reprint invoices
- Delete a sale (stock should be restored)

#### 7. Test Reports
- Generate sales reports with date filters
- View inventory reports
- Check profit calculations
- Verify top products analysis

#### 8. Test Settings
- Update company information
- Customize invoice header
- Customize invoice footer
- Change tax rates

### Mobile Testing
Test the POS interface on different screen sizes:
- Desktop (>1024px)
- Tablet (768px - 1024px)
- Mobile (<768px)

### Pre-deployment Validation

Before deploying to production, ensure:

1. ✅ Database migrations run successfully
2. ✅ All CRUD operations work for each module
3. ✅ POS system processes sales correctly
4. ✅ Stock quantities update automatically
5. ✅ Invoices print with correct information
6. ✅ Customer information appears on invoices
7. ✅ Reports generate accurate data
8. ✅ Mobile interface is responsive
9. ✅ Authentication works correctly
10. ✅ Low stock alerts appear

## Database Schema

- **categories**: Product categories
- **customers**: Customer information with unique codes
- **products**: Product information with stock
- **sales**: Sales transactions (linked to customers)
- **sale_items**: Sale line items
- **settings**: System configuration

## Tech Stack

- Laravel 12
- Laravel Breeze (Authentication)
- Tailwind CSS
- Alpine.js
- MySQL

## License

This project is open-sourced software licensed under the MIT license.
