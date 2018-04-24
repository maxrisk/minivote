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

        if (auth()->user()->hadVoteFor($this->id) != null) {
            return [
                'data' => parent::toArray($request),
                'result' => Vote::result(),
                'time_for_humans' => Carbon::parse($this->created_at)->diffForHumans()
            ];
        }

        return [
            'data' => parent::toArray($request),
            'time_for_humans' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
