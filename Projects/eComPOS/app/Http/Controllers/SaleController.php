<?php

namespace App\Http\Controllers;

use App\Enums\SalesType;
use App\Http\Requests\SaleRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CustomerGroupRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SaleRepository;

class SaleController extends Controller
{
    public function index()
    {
        $sales = SaleRepository::query()->orderByDesc('id')->where('type', 'Sales')->get();
        return view('sale.index', compact('sales'));
    }
    public function posSale()
    {
        $sales = SaleRepository::find(request()->id);
        return view('sale.pos.index', compact('sales'));
    }
    public function generateInvoice($id)
    {
        $sale = SaleRepository::find($id);
        return view('sale.invoice', compact('sale'));
    }
    public function draft()
    {
        $drafts = SaleRepository::query()->orderByDesc('id')->where('type', 'Draft')->get();
        return view('sale.draft', compact('drafts'));
    }

    public function orders()
    {
        $orders = SaleRepository::query()->orderByDesc('id')->where('type', 'Order')->get();
        return view('sale.orders', compact('orders'));
    }
    public function draftDelete(Sale $sale)
    {
        foreach ($sale->productSales as $draftProduct) {
            $draftProduct->product->update(['qty' => $draftProduct->product->qty + $draftProduct->qty]);
        }
        $sale->productSales()->delete();
        $sale->delete();
        return back()->with('success', 'Draft successfully deleted');
    }
    public function posData()
    {
        $categories = CategoryRepository::query()->whereNotNull('category_id')->orderbyDesc('id')->get();
        $brandes = BrandRepository::query()->get();
        $featuredProducts = ProductRepository::query()->whereNotNull('is_featured')->get();
        $customerGroups = CustomerGroupRepository::query()->get();
        return $this->json('Pos data', [
            'categories' => CategoryResource::collection($categories),
            'brands' => BrandResource::collection($brandes),
            'featuredProducts' => ProductResource::collection($featuredProducts),
            'barcodeDigits' => getSettings('barcode_digits') ?? 8,
            'customerGroups' => $customerGroups,
        ]);
    }
    public function sale(SaleRequest $request)
    {
        $user = $request->user();
        if (isset($user->carts) && $user->carts()->count() > 0) {
            $user->carts()->delete();
        }
        $sale = SaleRepository::storeByRequest($request);
        $message = 'Product successfull sold';
        if ($request->type == 'Draft') {
            $message = 'Product successfull drafted';
        }
        return $this->json($message, [
            'sale' => SaleResource::make($sale),
        ]);
    }

    public function orderStatus(Sale $sale, $status)
    {
        if ($status == 2) {
            $sale->update([
                'status' => $status,
                'type' => SalesType::SALES->value,
            ]);
        } else {
            $sale->update(['status' => $status]);
        }
        return back()->with('success', 'Order status successfully updated');
    }
}
