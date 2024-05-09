<?php

namespace App\Http\Resources\API;

use App\Http\Resources\API\Traits\UsePagination;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FileResourceCollection extends ResourceCollection
{
    use UsePagination;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collect()
        ];
    }
}
