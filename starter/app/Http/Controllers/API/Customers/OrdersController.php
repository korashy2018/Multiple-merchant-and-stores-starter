<?php

namespace App\Http\Controllers\API\Customers;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Customers\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\Order\OrderService;
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
            $createdOrder = (new OrderService())->createOrder($request);
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
