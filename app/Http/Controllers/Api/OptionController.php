<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OptionCollection;
use App\Models\Option;
use App\Models\Vote;
use App\Models\VoteOption;

class OptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('token.refresh');
    }

    public function vote($optionId)
    {
        $user = auth()->user();

        $option = Option::find($optionId);
        if (!$option) {
            return response()->json(['message' => '投票选项不存在']);
        }
        $vote = Vote::find($option->vote_id);

        $hadVotedOption = $user->hadVoteFor($option->vote_id);

        if ($hadVotedOption && $hadVotedOption->option_id == $optionId) {
            return new OptionCollection(Vote::find($option->vote_id)->result());
        }

        if ($hadVotedOption != null) {
            VoteOption::where('id', $hadVotedOption->id)->delete();
            Option::find($hadVotedOption->option_id)->decrement('vote_count');
            $vote->decrement('voters_count');
        }

        $user->voteFor($optionId, $option->vote_id);
        $vote->increment('voters_count');
        $option->increment('vote_count');

        return new OptionCollection(Vote::find($option->vote_id)->result());
    }
}
