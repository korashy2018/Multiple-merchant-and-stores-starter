<?php

namespace App\Http\Controllers\API\Merchants;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Merchants\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    private $merchant;

    public function __construct()
    {
        $this->merchant = auth('merchants')->user();
    }

    public function index(Store $store)
    {
        $products = $store->products()->paginate(5);
        return new ProductResourceCollection($products);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(ProductRequest $request, Store $store)
    {
        try {
            $data = $request->all();
            $createdProduct = $store->products()->create($data);
            return response()->json([
                'meta' => 'Product created successfully',
                'data' => new ProductResource($createdProduct)
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'message' => "there were error creating the product",
                'error'   => $exception->getMessage()
            ], 500);
        }
    }
}
