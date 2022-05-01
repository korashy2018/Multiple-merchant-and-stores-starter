<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'                  => $this->id,
            'sub_total'           => $this->total,
            'shippiong_sub_total' => $this->total_shipping_cost,
            'grand_total'         => $this->grand_total,
            'products'            => new ProductResourceCollection(
                $this->products
            )
        ];
    }

}
