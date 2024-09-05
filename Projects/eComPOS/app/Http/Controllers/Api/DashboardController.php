<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ProductSaleRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\SaleRepository;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $type = request()->type;

        $sales = SaleRepository::query()
            ->when($type == 'daily', function ($query) {
                return $query->where('created_at', date('Y-m-d'));
            })
            ->when($type == 'weekly', function ($query) {
                return $query->whereBetween('created_at', [now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d')]);
            })
            ->when($type == 'monthly', function ($query) {
                return $query->whereBetween('created_at', [now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d')]);
            })
            ->when($type == 'yearly', function ($query) {
                return $query->whereYear('created_at', date('Y'));
            })->get();

        $purchases = PurchaseRepository::query()
            ->when($type == 'daily', function ($query) {
                return $query->where('created_at', date('Y-m-d'));
            })
            ->when($type == 'weekly', function ($query) {
                return $query->whereBetween('created_at', [now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d')]);
            })
            ->when($type == 'monthly', function ($query) {
                return $query->whereBetween('created_at', [now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d')]);
            })
            ->when($type == 'yearly', function ($query) {
                return $query->whereYear('created_at', date('Y'));
            })->get();

        $totalProductSales = ProductSaleRepository::query()->whereIn('sale_id', $sales->pluck('id')->toArray())
            ->when($type == 'daily', function ($query) {
                return $query->where('created_at', date('Y-m-d'));
            })
            ->when($type == 'weekly', function ($query) {
                return $query->whereBetween('created_at', [now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d')]);
            })
            ->when($type == 'monthly', function ($query) {
                return $query->whereBetween('created_at', [now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d')]);
            })
            ->when($type == 'yearly', function ($query) {
                return $query->whereYear('created_at', date('Y'));
            })->get();

        $totalProfit = 0;
        foreach ($totalProductSales as $productSale) {
            $totalProfit += ($productSale->net_unit_price - $productSale->product->cost) * $productSale->qty;
        }

        // Get monthly purchase and sale
        $purchaseAndSales = [];
        $date = date('m') >= 6 ? 12 : 6;
        for ($i = 1; $i <= $date; $i++) {
            $month = Carbon::create(null, $i, 1);

            $totalPurchase = PurchaseRepository::query()
                
                ->whereBetween('created_at', [$month->startOfMonth()->format('Y-m-d'), $month->endOfMonth()->format('Y-m-d')])->sum('grand_total');
            $tatalSale = SaleRepository::query()
                
                ->whereBetween('created_at', [$month->startOfMonth()->format('Y-m-d'), $month->endOfMonth()->format('Y-m-d')])->sum('grand_total');

            $purchaseAndSales[$month->format('M')] = [
                'purchase' => (float) $totalPurchase,
                'sale' => (float) $tatalSale,
            ];
        }

        $maxPurchase = max(array_column($purchaseAndSales, 'purchase'));
        $maxSale = max(array_column($purchaseAndSales, 'sale'));

        $maxAmount = max($maxPurchase, $maxSale);

        return $this->json("Dashboard items", [
            'sale' => (float) $sales->sum('grand_total'),
            'purchase' => (float) $purchases->sum('grand_total'),
            'profit' => (float) $totalProfit,
            'purchase_due' => (float) ($purchases->sum('grand_total') - $purchases->sum('paid_amount')),
            'max_chart_amount' => (int) $maxAmount,
            'purchase_and_sale_chart' => array_values($purchaseAndSales)
        ]);
    }
}
