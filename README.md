# Laravel POS System

A comprehensive Point of Sale (POS) system built with Laravel 12, designed for retail stores with inventory management, sales tracking, and detailed reporting.

## Features

### Core Functionality
- **Point of Sale Interface**: Modern, intuitive POS interface for processing sales
- **Inventory Management**: Track stock levels with automatic updates after sales
- **Product Management**: Full CRUD operations for products with categories
- **Sales Management**: Complete sales history with detailed transaction records
- **Invoice Printing**: Customizable invoice templates with print functionality
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

4. **Run migrations**
   ```bash
   php artisan migrate
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

## Usage Guide

### Initial Setup
1. Register a new account
2. Configure company information in **Settings**
3. Add **Categories** for your products
4. Add **Products** with stock information

### Making a Sale
1. Navigate to **POS**
2. Select products to add to cart
3. Adjust quantities, tax, and discount
4. Complete sale and print invoice

### Managing Inventory
- Add/edit products from **Products** menu
- Monitor stock levels
- View low stock alerts on dashboard

## Key Features

- **Dashboard**: Quick overview with sales metrics
- **POS System**: Real-time product search and cart management
- **Reports**: Sales and inventory analytics
- **Invoice System**: Configurable templates with print support
- **Settings**: Company and invoice configuration

## Database Schema

- **categories**: Product categories
- **products**: Product information with stock
- **sales**: Sales transactions
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
