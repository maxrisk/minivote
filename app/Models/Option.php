<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['vote_id', 'title', 'vote_count'];

    public function vote() {
        return $this->belongsTo(Vote::class);
    }

    public function voteOption()
    {
        return $this->hasMany(VoteOption::class);
    }

    /**
     * 获取此选项的所有投票者
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVoters()
    {
        return $this->voteOption()->get();
    }
}
