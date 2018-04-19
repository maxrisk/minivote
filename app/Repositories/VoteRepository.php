<?php

namespace App\Repositories;

use App\Models\Vote;
use Illuminate\Http\Request;

/**
 * Class VoteRepository
 *
 * @package \App\Repositories
 */
class VoteRepository
{
    public function create($attributes)
    {
        $vote = Vote::create([
            'user_id' => auth()->user()->id,
            'title' => $attributes['title'],
            'content' => $attributes['content'],
            'is_private' => $attributes['is_private']
        ]);

        $added = $vote->options()->createMany($attributes['options']);

        return !! $added;
    }

    public function byId($id)
    {
        return Vote::with('options')->find($id);
    }
}
