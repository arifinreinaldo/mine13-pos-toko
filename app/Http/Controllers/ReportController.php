<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now()->endOfMonth());

        $sales = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->with(['user', 'saleItems.product'])
            ->latest()
            ->get();

        $totalSales = $sales->sum('total');
        $totalProfit = $sales->sum(function ($sale) {
            return $sale->saleItems->sum(function ($item) {
                return ($item->price - $item->product->cost) * $item->quantity;
            });
        });

        $salesByDay = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topProducts = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->select('products.name', DB::raw('SUM(sale_items.quantity) as total_quantity'), DB::raw('SUM(sale_items.subtotal) as total_sales'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get();

        return view('reports.sales', compact('sales', 'totalSales', 'totalProfit', 'salesByDay', 'topProducts', 'startDate', 'endDate'));
    }

    public function inventory()
    {
        $products = Product::with('category')->get();

        $totalValue = $products->sum(function ($product) {
            return $product->stock_quantity * $product->cost;
        });

        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'minimum_stock')
            ->with('category')
            ->get();

        $categoryInventory = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(products.stock_quantity * products.cost) as total_value'), DB::raw('SUM(products.stock_quantity) as total_quantity'))
            ->groupBy('categories.id', 'categories.name')
            ->get();

        return view('reports.inventory', compact('products', 'totalValue', 'lowStockProducts', 'categoryInventory'));
    }
}
