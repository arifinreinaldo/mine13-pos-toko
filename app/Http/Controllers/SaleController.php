<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Setting;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['user', 'saleItems.product'])
            ->latest()
            ->paginate(20);

        return view('sales.index', compact('sales'));
    }

    public function show(Sale $sale)
    {
        $sale->load(['user', 'saleItems.product']);
        return view('sales.show', compact('sale'));
    }

    public function invoice(Sale $sale)
    {
        $sale->load(['user', 'saleItems.product']);

        $settings = [
            'company_name' => Setting::get('company_name', 'POS System'),
            'company_address' => Setting::get('company_address', ''),
            'company_phone' => Setting::get('company_phone', ''),
            'company_email' => Setting::get('company_email', ''),
            'invoice_header' => Setting::get('invoice_header', ''),
            'invoice_footer' => Setting::get('invoice_footer', 'Thank you for your business!'),
        ];

        return view('sales.invoice', compact('sale', 'settings'));
    }

    public function destroy(Sale $sale)
    {
        foreach ($sale->saleItems as $item) {
            $item->product->increment('stock_quantity', $item->quantity);
        }

        $sale->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Sale deleted and stock restored successfully.');
    }
}
