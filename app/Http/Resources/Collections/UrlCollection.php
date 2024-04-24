<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\UrlResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class UrlCollection.
 */
class UrlCollection extends ResourceCollection
{
    /**
     * @var string
     */
    public $collects = UrlResource::class;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
