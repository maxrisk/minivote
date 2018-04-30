<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreVoteRequest;
use App\Http\Requests\UpdateVoteRequest;
use App\Http\Resources\Vote as VoteResource;
use App\Http\Resources\VoteCollection;
use App\Http\Resources\VoterResource;
use App\Repositories\VoteRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * @var VoteRepository
     */
    protected $voteRepository;

    public function __construct(VoteRepository $repository)
    {
        $this->middleware(['token.refresh']);
        $this->voteRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $filters = ['all', 'popular', 'mine'];

        $filter = in_array($request->get('filter'), $filters)
            ? $request->get('filter')
            : 'all';

        $size = $request->get('size') ?: 10;

        $votes = $this->voteRepository->pagination($size, $filter);

        return new VoteCollection($votes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreVoteRequest $request
     * @return VoteResource
     */
    public function store(StoreVoteRequest $request)
    {
        $created = $this->voteRepository->create($request->all());

        return new VoteResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return VoteResource
     */
    public function show($id)
    {
        $vote = $this->voteRepository->byId($id);

        return new VoteResource($vote);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateVoteRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVoteRequest $request, $id)
    {
        $updated = $this->voteRepository->update(
            $id,
            $request->only('title', 'content', 'is_private', 'is_active'),
            $request->get('options')
        );

        if ($updated) {
            return response()->json(['message' => '更新成功']);
        }

        return response()->json(['message' => '更新失败'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = auth()->user()->deleteVote($id);

        if (!$deleted) {
            return response()->json(['message' => '删除失败'], 400);
        }

        return response()->json(['message' => '删除成功']);
    }

    /**
     * 获取投票者列表
     *
     * @param $vote
     * @return VoterResource
     */
    public function getVoters($vote)
    {
        $voters = $this->voteRepository->getVoteOptionsBy($vote);

        return new VoterResource($voters);
    }
}
