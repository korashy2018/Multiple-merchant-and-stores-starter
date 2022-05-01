<?php

namespace App\Http\Controllers\API\Customers;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Customers\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    private $customer;

    public function __construct()
    {
        $this->customer = auth('customers')->user();
    }

    public function store(OrderRequest $request)
    {
        try {
            $data = $request->all();
            $orderTotal = 0;
            $totalShippingCost = 0;
            $productIds = [];
            foreach ($data['cart'] as $cartItem) {
                $product = Product::with(['store', 'store.storeSetting'])->find(
                    $cartItem['id']
                );
                $orderTotal += $cartItem['price'] * $cartItem['quantity'];
                $totalShippingCost += $product->store->storeSetting->shipping_cost
                    ?? 0;
                $productIds []
                    = [
                    $cartItem['id'] => [
                        'quantity' => $cartItem['quantity'],
                        'price'    => $cartItem['price']
                    ]
                ];
            }
            $createdOrder = Order::create([
                'total'               => $orderTotal,
                'total_shipping_cost' => $totalShippingCost,
                'grand_total'         => $orderTotal + $totalShippingCost,
                'customer_id'         => $this->customer->id
            ]);
            foreach ($productIds as $id) {
                $createdOrder->products()->attach($id);
            }
            return response()->json([
                'meta' => 'Order created successfully',
                'data' => new OrderResource($createdOrder)
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'message' => "there were error creating the order",
                'error'   => $exception->getMessage()
            ], 500);
        }
    }
}
