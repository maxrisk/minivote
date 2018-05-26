<?php

namespace App\Repositories;

use App\Models\Option;
use App\Models\Report;
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
            'content' => $attributes['content'] ?? '',
            'is_private' => $attributes['is_private'] ?? 'F'
        ]);

        $vote->options()->createMany($attributes['options']);
        if (isset($attributes['images'])) {
            $vote->images()->createMany($attributes['images']);
        }

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
        return Vote::with([
            'options' => function ($query)
            {
                $query->select('id', 'vote_id', 'title', 'vote_count');
            },
            'images' => function ($query)
            {
                $query->select('id', 'vote_id', 'path');
            }
        ])->find($id);
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
     * @param int $size 每页显示条数
     * @param string $filter
     * @return mixed
     */
    public function pagination($size, $filter = 'all')
    {
        $size = $size ?: 10;
        if ($filter == 'popular') {
            return Vote::with(['options', 'user', 'images' => function ($query) {
                $query->select('id', 'vote_id', 'path');
            }])->active()->notPrivate()->orderByDesc('voters_count')->orderByDesc('created_at')->limit(50)->paginate($size);
        }

        return Vote::with(['options', 'user', 'images' => function ($query) {
            $query->select('id', 'vote_id', 'path');
        }])
            ->when($filter == 'all', function ($query) {
                return $query->active()->notPrivate();
            })
            ->when($filter == 'mine', function ($query) {
                return $query->where('user_id', auth()->user()->id);
            })
            ->orderBy('created_at', 'desc')->paginate($size);
    }

    public function getVoteOptionsBy($vote)
    {
        return Vote::with('options')->active()->select('id', 'user_id', 'title')->find($vote);
    }

    /**
     * 举报投票
     *
     * @param string/int $user 举报人的 ID
     * @param string/int $vote 投票 ID
     * @param string $message 举报原因
     * @return mixed
     */
    public function report($user, $vote, $message)
    {
        return Report::create([
            'vote_id' => $vote,
            'message' => $message,
            'user_id' => $user
        ]);
    }
}
