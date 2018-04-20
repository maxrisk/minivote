<?php

namespace App\Repositories;

use App\Http\Resources\VoteCollection;
use App\Models\Option;
use App\Models\Vote;

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
            'is_private' => $attributes['is_private'] ?? 'F'
        ]);

        $vote->options()->createMany($attributes['options']);

        return $vote->with('options')->first();
    }

    public function byId($id)
    {
        return Vote::with('options')->find($id);
    }

    public function update($id, $voteAttributes, $optionAttributes = null)
    {
        $vote = Vote::find($id);
        $updated = $vote->update($voteAttributes);

        if ($optionAttributes != null) {
            foreach ($optionAttributes as $item) {
                $res = Option::where('id', $item['id'])->update(array_except($item, ['id']));
                $updated = $updated && $res;
            }
        }

        return $updated;
    }

    public function pagination()
    {
        return new VoteCollection(Vote::paginate(10));
    }
}
