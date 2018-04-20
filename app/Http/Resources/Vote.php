<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

class Vote extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        Carbon::setLocale('zh');

        return [
            'data' => parent::toArray($request),
            'time_for_humans' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
