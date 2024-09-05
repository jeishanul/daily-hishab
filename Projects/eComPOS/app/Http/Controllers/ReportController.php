<?php

namespace App\Http\Controllers;

use App\Repositories\ExpenseRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductSaleRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\SaleRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WarehouseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function summary()
    {
        $purchases = PurchaseRepository::query()->whereMonth('created_at', date('m'))->get();
        $sales = SaleRepository::query()->whereMonth('created_at', date('m'))->get();
        $transactions = TransactionRepository::query()->whereMonth('created_at', date('m'))->where('transection_type', 'Credit')->get();

        //purchase
        $totalPurchasesAmount = $purchases->sum('grand_total');
        $totalPaidAmount = $purchases->sum('paid_amount');
        $totalPurchasesTax = $purchases->sum('total_tax');
        $totalPurchaseProducts = $purchases->sum('total_qty');
        $totalPurchasesDiscount = $purchases->sum('total_discount');

        //sales
        $totalSaleAmount = $sales->sum('grand_total');
        $totalSaleTax = $sales->sum('total_tax');
        $totalSaleProducts = $sales->sum('total_qty');
        $totalSaleDiscount = $sales->sum('total_discount');

        //transactions
        $totalPaymentRecieved = $transactions->sum('amount');
        $totalPaymentRecievedCash = $transactions->where('payment_method', 'Cash')->sum('amount');
        $totalPaymentRecievedBank = $transactions->where('payment_method', 'Bank')->sum('amount');
        $totalPaymentRecievedCashCount = $transactions->where('payment_method', 'Cash')->count();
        $totalPaymentRecievedBankCount = $transactions->where('payment_method', 'Bank')->count();

        $monthlyTotalProductSales = ProductSaleRepository::query()->whereMonth('created_at', date('m'))->get();
        $monthlyProfit = 0;
        foreach ($monthlyTotalProductSales as $productSales) {
            $monthlyProfit += ($productSales->net_unit_price - $productSales->product->cost) * $productSales->qty;
        }

        return view('report.summary', compact(
            'totalPurchasesAmount',
            'totalPurchaseProducts',
            'totalPaidAmount',
            'totalPurchasesTax',
            'totalPurchasesDiscount',
            'totalSaleAmount',
            'totalSaleTax',
            'totalSaleDiscount',
            'totalSaleProducts',
            'totalPaymentRecieved',
            'totalPaymentRecievedCash',
            'totalPaymentRecievedBank',
            'totalPaymentRecievedCashCount',
            'totalPaymentRecievedBankCount',
            'monthlyProfit'
        ));
    }

    public function sales()
    {
        $request = request();
        $start_date = $request->start_date ?? date('Y-m-d');
        $end_date = $request->end_date ?? date('Y-m-d', strtotime('+7 days'));

        $hasDate = $start_date && $end_date ? true : false;

        $sales = SaleRepository::query()->orderByDesc('id')->where('type', 'Sales')
            ->when($hasDate, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('created_at', [$start_date, $end_date]);
            })->get();
        return view('report.sales', compact('sales'));
    }

    public function salePrint()
    {
        $request = request();
        $start_date = $request->start_date ?? date('Y-m-d');
        $end_date = $request->end_date ?? date('Y-m-d', strtotime('+7 days'));

        $hasDate = $start_date && $end_date ? true : false;

        $sales = SaleRepository::query()->orderByDesc('id')->where('type', 'Sales')
            ->when($hasDate, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('created_at', [$start_date, $end_date]);
            })->get();
        return view('report.salePrint', compact('sales'));
    }

    public function purchases()
    {
        $request = request();
        $warehouseId = $request->warehouse_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $hasDate = $startDate && $endDate ? true : false;

        $purchases = PurchaseRepository::query()->orderByDesc('id')
            ->when($warehouseId, function ($query) use ($warehouseId) {
                $query->where('warehouse_id', $warehouseId);
            })
            ->when($hasDate, function ($query) use ($startDate, $endDate) {
                $query->wherebetween('date', [$startDate, $endDate]);
            })->get();
        $warehouses = WarehouseRepository::query()->orderByDesc('id')->get();

        return view('report.purchases', compact('purchases', 'warehouses'));
    }

    public function purchasesPrint()
    {
        $request = request();
        $purchases = PurchaseRepository::query()->get();
        return view('report.purchasePrint', compact('purchases'));
    }

    public function product()
    {
        $request = request();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $status = $request->status;
        $hasDate = $start_date && $end_date ? true : false;

        $products = ProductRepository::query()
            ->when($status, function ($query) use ($status) {
                $query->where('type', $status);
            })
            ->when($hasDate, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('created_at', [$start_date, $end_date]);
            })->get();

        return view('report.product', compact('products'));
    }

    public function productPrint()
    {
        $request = request();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $status = $request->status;
        $hasDate = $start_date && $end_date ? true : false;

        $products = ProductRepository::query()
            ->when($status, function ($query) use ($status) {
                $query->where('type', $status);
            })
            ->when($hasDate, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('created_at', [$start_date, $end_date]);
            })->get();

        return view('report.productPrint', compact('products'));
    }

    public function expense()
    {
        $request = request();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $hasDate = $start_date && $end_date ? true : false;

        $expenses = ExpenseRepository::query()
            ->when($hasDate, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('created_at', [$start_date, $end_date]);
            })->get();
        return view('report.expense', compact('expenses'));
    }

    public function profitLoss()
    {
        $request = request();
        $saleProducts = [];
        $sales = [];
        $purchases = [];
        if ($request->report_type && $request->daterange) {
            $dates = explode(' - ', $request->daterange);
            $from = Carbon::parse($dates[0]);
            $to = Carbon::parse($dates[1]);
            if ($request->report_type == 1) {
                $saleProducts = ProductSaleRepository::query()
                    ->whereBetween('created_at', [$from, $to])
                    ->select('product_id', DB::raw('SUM(qty) as total_qty'))
                    ->groupBy('product_id')
                    ->get();
            } elseif ($request->report_type == 2) {
                $sales = SaleRepository::query()
                    ->whereBetween('created_at', [$from, $to])
                    ->get();
                $purchases = PurchaseRepository::query()
                    ->whereBetween('created_at', [$from, $to])
                    ->get();
            }
        }
        return view('report.profit_loss', compact('saleProducts', 'sales', 'purchases'));
    }
}
