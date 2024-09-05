<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleReturnRequest;
use App\Http\Requests\SearchInvoiceNoRequest;
use App\Models\Sale;
use App\Repositories\SaleRepository;
use App\Repositories\SaleReturnProductRepository;
use App\Repositories\SaleReturnRepository;
use Illuminate\Http\Request;

class SaleReturnController extends Controller
{
    public function index()
    {
        $saleReturns = SaleReturnRepository::query()->orderByDesc('id')->get();
        return view('saleReturn.index', compact('saleReturns'));
    }
    public function search(SearchInvoiceNoRequest $request)
    {
        $sale = SaleRepository::query()->where('reference_no', $request->invoice_no)->first();
        if (!$sale) {
            return back()->with('error', 'Invalid invoice no! Please Provied a valid invoice no');
        }
        return to_route('sale.return.details', $sale->id);
    }
    public function details(Sale $sale)
    {
        return view('saleReturn.create', compact('sale'));
    }
    public function returnProduct(SaleReturnRequest $request, Sale $sale)
    {
        foreach ($request->products as $product) {
            $saleProduct = $sale->productSales()->where('product_id', $product['id'])->first();
            $qty = $saleProduct->qty - $product['qty'];
            $saleProduct->update([
                'qty' => $product['qty'],
                'total' => $product['qty'] * $saleProduct->product->price,
            ]);
            $saleProduct->product->update([
                'qty' => $saleProduct->product->qty + $qty
            ]);
        }
        $sale->update([
            'total_discount' => $request->total_discount,
            'total_tax' => $request->total_tax,
            'total_qty' => $request->total_qty,
            'total_products' => $request->item,
            'total_price' => $request->total_price,
            'order_tax' => $request->order_tax,
            'grand_total' => $request->grand_total,
            'sale_note' => $request->note,
        ]);
        $saleReturn = SaleReturnRepository::storeByRequest($request, $sale);
        SaleReturnProductRepository::storeByRequest($request, $saleReturn, $sale);
        return back()->with('success', 'Product successfully returned!');
    }
}
