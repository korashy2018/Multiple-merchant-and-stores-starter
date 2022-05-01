<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'store_name'  => $this->store->name,
            'price'       => $this->store->storeSetting->vat_included
                ? $this->price
                : round(
                    (($this->store->storeSetting->vat_percentage / 100)
                        * $this->price) + $this->price,
                    2
                )
        ];
    }

}
