<?php

namespace App\Http\Controllers\API\Customers;

use App\Http\Controllers\Controller;
use App\Http\Resources\MerchantResourceCollection;
use App\Http\Resources\ProductResourceCollection;
use App\Http\Resources\StoreResourceCollection;
use App\Models\Merchant;
use App\Models\Store;

class DataController extends Controller
{
    private $customer;

    public function __construct()
    {
        $this->customer = auth('customers')->user();
    }

    public function listMerchants()
    {
        $merchants = Merchant::paginate(5);
        return new MerchantResourceCollection($merchants);
    }

    public function listStores(Merchant $merchant)
    {
        $stores = $merchant->stores()->paginate(5);
        return new StoreResourceCollection($stores);
    }

    public function listStoreProducts(Store $store): ProductResourceCollection
    {
        $products = $store->products()->paginate(5);
        return new ProductResourceCollection($products);
    }
}
