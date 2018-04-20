<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\VoteOption;

class OptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function vote($optionId)
    {
        $user = auth()->user();

        $option = Option::find($optionId);
        if (!$option) {
            return response()->json(['code' => 400, 'message' => '投票不存在']);
        }

        $hadVotedOption = $user->hadVoteFor($option->vote_id);

        if ($hadVotedOption && $hadVotedOption->option_id == $optionId) {
            return response()->json(['code' => 200, 'message' => '成功投票']);
        }

        if ($hadVotedOption != null) {
            VoteOption::where('id', $hadVotedOption->id)->delete();
            Option::find($hadVotedOption->option_id)->decrement('vote_count');
        }

        $user->voteFor($optionId, $option->vote_id);
        $option->increment('vote_count');

        return response()->json(['code' => 200, 'message' => '成功投票']);
    }
}
