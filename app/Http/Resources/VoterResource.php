<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class VoterResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        foreach ($this->options as $option) {
            $voters = [];
            foreach ($option->getVoters() as $voter) {
                $voters[] = $voter->user()->avatar_url;
            }
            $option->voters = $voters;
        }

        return parent::toArray($request);
    }
}
