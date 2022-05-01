<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'merchant_name' => $this->merchant->name,
            'settings'      => [
                'vat_included'   => $this->storeSetting->vat_included,
                'vat_percentage' => $this->storeSetting->vat_percentage,
                'shipping_cost'  => $this->storeSetting->shipping_cost
            ]
        ];
    }
}
