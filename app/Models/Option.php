<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['vote_id', 'title', 'image_url', 'vote_count'];

    public function vote() {
        return $this->belongsTo(Vote::class);
    }

    public function voteOption()
    {
        return $this->hasMany(VoteOption::class);
    }
}
