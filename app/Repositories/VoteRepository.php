<?php

namespace App\Repositories;

use App\Models\Option;
use App\Models\Vote;

/**
 * Class VoteRepository
 *
 * @package \App\Repositories
 */
class VoteRepository
{
    /**
     * 创建投票
     *
     * @param $attributes
     * @return mixed
     */
    public function create($attributes)
    {
        $vote = Vote::create([
            'user_id' => auth()->user()->id,
            'title' => $attributes['title'],
            'content' => $attributes['content'],
            'is_private' => $attributes['is_private'] ?? 'F'
        ]);

        $vote->options()->createMany($attributes['options']);

        return $vote->with('options')->find($vote->id);
    }

    /**
     * 按 ID 查询投票
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function byId($id)
    {
        return Vote::with('options')->find($id);
    }

    /**
     * 更新投票信息
     *
     * @param $id
     * @param $voteAttributes
     * @param null $optionAttributes
     * @return bool
     */
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

    /**
     * 查询用户发起的投票列表
     *
     * @return mixed
     */
    public function pagination()
    {
        return Vote::active()->notPrivate()->paginate(10);
    }

    public function getVoteOptionsBy($vote)
    {
        return Vote::with('options')->active()->select('id', 'user_id', 'title')->find($vote);
    }
}
