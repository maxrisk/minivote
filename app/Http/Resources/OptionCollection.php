<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OptionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $count = 0;
        foreach ($this->collection as $item) {
            $count += $item->vote_count;
        }

        return [
            'data' => $this->collection,
            'count' => $count
        ];
    }
}
