<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SpotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'category' => $this->category,
            'available_location' => $this->available_location,
            'postal_code' => $this->postal_code,
            'prefecture' => $this->prefecture,
            'tel' => $this->format_tel,
            'opening_hour' => $this->opening_hour,
            'ssid' => $this->ssid,
            'limitation' => $this->limitation,
            'usage' => $this->usage,
            'url' => $this->url,
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];

        return $data;
    }
}
