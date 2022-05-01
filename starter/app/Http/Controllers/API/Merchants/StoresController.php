<?php

namespace App\Http\Controllers\API\Merchants;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Merchants\StoreRequest;
use App\Http\Resources\StoreResource;
use App\Http\Resources\StoreResourceCollection;
use App\Models\Store;
use Illuminate\Support\Facades\Log;

class StoresController extends Controller
{
    private $merchant;

    public function __construct()
    {
        $this->merchant = auth('merchants')->user();
    }

    public function index()
    {
        $stores = $this->merchant->stores()->with('translations')->paginate(5);
        return new StoreResourceCollection($stores);
    }

    public function show(Store $store)
    {
        return new StoreResource($store);
    }

    public function store(StoreRequest $request)
    {
        try {
            $storeData = $request->except('settings');

            $storeSettingsData = $request->only('settings');
            $merchant_id = $this->merchant->id;
            $storeData['merchant_id'] = $merchant_id;
            $createdStore = Store::create($storeData);
            $createdStore->storeSetting()->create(
                $storeSettingsData['settings']
            );
            return response()->json([
                'meta' => 'store created successfully',
                'data' => new StoreResource($createdStore)
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'message' => "there were error creating the store",
                'error'   => $exception->getMessage()
            ], 500);
        }
    }
}
