<?php

namespace App\Services\Order;


use App\Models\Order;
use App\Models\Product;

class OrderService
{
    public function createOrder($request)
    {
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
        return $createdOrder;
    }
}
