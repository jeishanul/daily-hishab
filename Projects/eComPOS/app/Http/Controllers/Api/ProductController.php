<?php

namespace App\Http\Controllers\Api;

use App\Enums\BarcodeSymbology;
use App\Enums\ProductTypes;
use App\Enums\TaxMethods;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductDetailsResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SingelProductResource;
use App\Http\Resources\TaxResource;
use App\Http\Resources\UnitResource;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TaxRepository;
use App\Repositories\UnitRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $request = request();
        $search = $request->search;

        $page = $request->page ?? 1;
        $perPage = $request->per_page  ?? 15;
        $skip = ($page * $perPage) - $perPage;

        $productSearch = ProductRepository::search($search);
        $totalProduct = $productSearch->count();

        $products = $productSearch->skip($skip)->take($perPage)->get();


        return $this->json('Search Products', [
            'total' => $totalProduct,
            'products' => SingelProductResource::collection($products),
        ]);
    }

    public function search()
    {
        $request = request();
        $search = $request->search;
        $categoryId = $request->category_id;
        $brandId = $request->brand_id;

        $page = $request->page;
        $take = $request->take;
        $skip = ($page * $take) - $take;

        $productSearch = ProductRepository::search($search, $categoryId, $brandId);
        $totalProduct = $productSearch->count();

        $products = $productSearch->when($page && $take, function ($query) use ($skip, $take) {
            $query->skip($skip)->take($take);
        })->get();


        return $this->json('Search Products', [
            'total' => $totalProduct,
            'products' => ProductResource::collection($products),
        ]);
    }

    public function categoryProduct(Category $category)
    {
        $products = $category->product;
        return $this->json('Product list', [
            'products' => ProductResource::collection($products),
        ]);
    }

    public function show(Product $product)
    {
        return $this->json('Product Details', [
            'product' => ProductDetailsResource::make($product),
        ]);
    }

    public function destroy(Product $product)
    {
        $media = $product->media;
        if ($media && Storage::exists($media->src)) {
            Storage::delete($media->src);
        }
        $product->delete();
        return $this->json('Product Deleted Successfully');
    }

    public function store(ProductRequest $request)
    {
        $product = ProductRepository::storeByRequest($request);
        return $this->json('Product Details', [
            'product' => ProductDetailsResource::make($product),
        ]);
    }

    public function addProductInfo()
    {
        $categories = CategoryRepository::query()->get();
        $brands = BrandRepository::query()->get();
        $units = UnitRepository::query()->get();
        $taxs = TaxRepository::query()->get();
        $barcodeSymbologyes = BarcodeSymbology::cases();
        $productTypes = ProductTypes::cases();
        $taxMethods = TaxMethods::cases();
        return $this->json('Product Details', [
            'categories' => CategoryResource::collection($categories),
            'brands' => BrandResource::collection($brands),
            'units' => UnitResource::collection($units),
            'taxs' => TaxResource::collection($taxs),
            'barcodeSymbologyes' => $barcodeSymbologyes,
            'productTypes' => $productTypes,
            'taxMethods' => $taxMethods,
        ]);
    }
}
