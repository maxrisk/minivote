<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id', 'title', 'content', 'is_private', 'is_active'];

    /**
     * 监听删除事件
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function($vote) {
            $vote->options()->delete();
            $vote->voteOption()->delete();
        });
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function voteOption()
    {
        return $this->hasMany(VoteOption::class);
    }

    /**
     * 限制查询只包括受激活状态的投票。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 'T');
    }

    /**
     * 限制查询只包括活跃的用户。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotPrivate($query)
    {
        return $query->where('is_private', 'F');
    }

    /**
     * 查询所有投票结果
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function result()
    {
        return $this->options()->select('id', 'title', 'vote_count')->get();
    }

    public function getVoteOptions()
    {
        return $this->voteOption()->get();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')
                    ->select('id', 'avatar_url', 'nick_name');
    }
}
