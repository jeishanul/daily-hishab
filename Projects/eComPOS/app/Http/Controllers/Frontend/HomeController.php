<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\BannerResource;
use App\Http\Resources\CartResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CustomerChoiceProductResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Banner;
use App\Repositories\CategoryRepository;
use App\Repositories\CouponRepository;
use App\Repositories\PersonalInfoRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductSaleRepository;
use App\Repositories\SaleRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }
    public function productDetails($slug)
    {
        return view('frontend.product_details', compact('slug'));
    }

    public function ajaxProductDetails($slug)
    {
        $product = ProductRepository::query()->where('slug', $slug)->first();
        if (!$product) {
            return $this->json('Product not found', [], 404);
        }
        return $this->json("Product Details", [
            'product' => ProductResource::make($product),
        ]);
    }
    public function checkout()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if(auth()->user()->carts()->count() == 0){
            return redirect()->route('home')->with('error', 'Cart is empty');
        }
        return view('frontend.checkout');
    }
    public function profile()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        return view('frontend.profile');
    }

    public function categories()
    {
        $categories = CategoryRepository::query()->whereNull('category_id')->orderByDesc('id')->get();
        return $this->json("Parent Categories", [
            'categories' => CategoryResource::collection($categories),
        ]);
    }

    public function newProducts()
    {
        $products = ProductRepository::query()->orderByDesc('id')->take(12)->get();
        return $this->json("New Products", [
            'products' => ProductResource::collection($products),
        ]);
    }

    public function customerChoiceProducts()
    {
        $products = ProductSaleRepository::query()->selectRaw('SUM(qty) as total_quantity, product_id')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(12)
            ->get();
        return $this->json("Customer Choice Products", [
            'products' => CustomerChoiceProductResource::collection($products),
        ]);
    }

    public function banners()
    {
        $banners = Banner::active()->get();
        return $this->json("Banners", [
            'banners' => BannerResource::collection($banners),
        ]);
    }

    public function bigSaleProducts()
    {
        $currentDate = Carbon::today();

        $products = ProductRepository::query()
            ->whereDate('starting_date', '<=', $currentDate)
            ->whereDate('ending_date', '>=', $currentDate)
            ->orderBy('promotion_price', 'asc')
            ->take(12)
            ->get();

        return $this->json("Big Sale Products", [
            'products' => ProductResource::collection($products),
        ]);
    }

    public function bestDealProducts()
    {
        $currentDate = Carbon::today();

        $products = ProductRepository::query()
            ->whereDate('starting_date', '<=', $currentDate)
            ->whereDate('ending_date', '>=', $currentDate)
            ->orderBy('qty', 'asc')
            ->where('qty', '>', 0)
            ->take(12)
            ->get();

        return $this->json("Best Deal Products", [
            'products' => ProductResource::collection($products),
        ]);
    }

    public function viewAllProducts($type, $slug)
    {
        return view('frontend.view_products', compact('type', 'slug'));
    }

    public function viewAllProductsAjax($type, $slug)
    {
        $products = ProductRepository::getAll();
        if ($type == 'category' || $type == 'subcategory') {
            $products = $this->allCategoryWiseProducts($type, $slug);
        } elseif ($type == 'best-deal') {
            $products = $this->bestDealWiseProducts();
        } elseif ($type == 'customer-choice') {
            $products = $this->customerChoiceWiseProducts();
        } elseif ($type == 'new-products') {
            $products = $this->newWiseProducts();
        } elseif ($type == 'big-sale') {
            $products = $this->bigSaleWiseProducts();
        } elseif ($type == 'search') {
            $products = $this->searchProducts($slug);
        }

        return $this->json("View All Products", [
            'products' => ProductResource::collection($products),
        ]);
    }

    public function allCategoryWiseProducts($type, $slug)
    {
        $category = CategoryRepository::query()->where('slug', $slug)->firstOrFail();
        $products = ProductRepository::query()->where('category_id', $category->id)->get();
        return $products;
    }
    public function bestDealWiseProducts()
    {
        $currentDate = Carbon::today();

        $products = ProductRepository::query()
            ->whereDate('starting_date', '<=', $currentDate)
            ->whereDate('ending_date', '>=', $currentDate)
            ->orderBy('qty', 'asc')
            ->where('qty', '>', 0)
            ->get();

        return $products;
    }

    public function bigSaleWiseProducts()
    {
        $currentDate = Carbon::today();

        $products = ProductRepository::query()
            ->whereDate('starting_date', '<=', $currentDate)
            ->whereDate('ending_date', '>=', $currentDate)
            ->whereNotNull('promotion_price')
            ->orderBy('promotion_price', 'asc')
            ->get();

        return $products;
    }

    public function newWiseProducts()
    {
        $products = ProductRepository::query()->orderByDesc('id')->get();
        return $products;
    }

    public function customerChoiceWiseProducts()
    {
        $products = ProductSaleRepository::query()->selectRaw('SUM(qty) as total_quantity, product_id')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->get();
        return $products;
    }

    public function searchProducts($slug)
    {
        $products = ProductRepository::query()->where('name', 'like', '%' . $slug . '%')->get();
        return $products;
    }

    public function addProductToWishlist(Request $request)
    {
        $request->user();
        if (!$request->user()) {
            return $this->json('you are not authorized, please login first,', [], 401);
        }

        if ($request->user()->wishlist()->where('product_id', $request->product_id)->exists()) {
            return $this->json('Product already added to wishlist', [], 422);
        }

        $request->user()->wishlist()->attach($request->product_id);

        return $this->json('Product added to wishlist successfully', [], 200);
    }

    public function removeProductFromWishlist(Request $request)
    {
        $request->user();
        if (!$request->user()) {
            return $this->json('you are not authorized, please login first,', [], 401);
        }
        $request->user()->wishlist()->detach($request->product_id);
        return $this->json('Product removed from wishlist successfully', [], 200);
    }

    public function addProductToCart(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'You are not authorized, please login first.'], 401);
        }

        // Find the cart item for the product, if it exists
        $cartItem = $user->carts()->where('product_id', $request->product_id)->first();
        // Calculate the new quantity
        $newQty = ($cartItem ? $cartItem->qty : 0) + $request->qty;
        $message = 'Product added to cart or quantity updated successfully';
        if ($request->type == 'remove') {
            // Calculate the new quantity
            $newQty = ($cartItem ? $cartItem->qty : 0) - $request->qty;
            $message = 'Product removed from cart or quantity updated successfully';
        }

        // Update the cart or create a new entry
        $user->carts()->updateOrCreate(
            ['product_id' => $request->product_id],
            ['qty' => $newQty]
        );

        return response()->json(['message' => $message], 200);
    }

    public function ajaxWishlist(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'You are not authorized, please login first.'], 401);
        }

        $products = $user->wishlist;

        return $this->json("Wishlist Products", [
            'products_count' => $products->count(),
            'products' => ProductResource::collection($products),
        ]);
    }

    public function ajaxWishlistRemove(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'You are not authorized, please login first.'], 401);
        }

        $user->wishlist()->wherePivot('product_id', $request->id)->detach();
        return $this->json(" Product removed from wishlist successfully", [], 200);
    }

    public function ajaxCarts(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'You are not authorized, please login first.'], 401);
        }

        $products = $user->carts()->get();

        return $this->json("Wishlist Products", [
            'products_count' => $products->count(),
            'products' => CartResource::collection($products),
        ]);
    }

    public function ajaxCartsRemove(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'You are not authorized, please login first.'], 401);
        }
        $user->carts()->where('id', $request->id)->delete();
        return $this->json(" Product removed from cart successfully", [], 200);
    }

    public function couponValidate(Request $request)
    {
        if ($request->coupon_id) {
            return $this->json('Coupon already applied', [], 422);
        }
        $couponCode = CouponRepository::query()->where('code', $request->coupon)->first();
        if (!$couponCode) {
            return $this->json('Promo Code Not Match!', [], 422);
        }

        $discount = $couponCode->amount;
        if ($couponCode->type->value == 'Percentage') {
            $discount = $request->price * $couponCode->amount / 100;
        } else {
            if ($couponCode->min_amount && $couponCode->min_amount > $request->price) {
                return $this->json('Minimum Purchase Amount is ' . $couponCode->min_amount, [], 422);
            }
            if ($couponCode->max_amount && $couponCode->max_amount < $request->price) {
                return $this->json('Maximum Purchase Amount is ' . $couponCode->max_amount, [], 422);
            }
        }

        return $this->json('Coupon succesfully applied', [
            'id' => $couponCode->id,
            'discount' => $discount,
        ]);
    }

    public function ajaxProfileUpdate(CustomerRequest $request)
    {
        $user = UserRepository::updateByRequest($request, $request->user());
        PersonalInfoRepository::createOrUpdateByRequest($request, $user->personalInfo);
        return $this->json("Profile updated successfully", [
            'user' => CustomerResource::make($user),
        ], 200);
    }

    public function myOrders(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'You are not authorized, please login first.'], 401);
        }
        $orders = SaleRepository::query()->where('customer_id', $user->id)->get();

        return $this->json("Orders", [
            'all' => OrderResource::collection($orders),
            'pending' => OrderResource::collection($orders->where('status', 0)),
            'on_process' => OrderResource::collection($orders->where('status', 1)),
            'delivered' => OrderResource::collection($orders->where('status', 2)),
            'cancelled' => OrderResource::collection($orders->where('status', 3)),
        ]);
    }
}
