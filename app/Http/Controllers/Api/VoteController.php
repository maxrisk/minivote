<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreVoteRequest;
use App\Http\Resources\Vote;
use App\Repositories\VoteRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VoteController extends Controller
{
    protected $voteRepository;

    public function __construct(VoteRepository $repository)
    {
        $this->middleware('jwt.auth');
        $this->voteRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVoteRequest $request)
    {
        $created = $this->voteRepository->create($request->all());

        if ($created) {
            return response()->json(['created' => true]);
        }

        return response()->json(['created' => false]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Vote
     */
    public function show($id)
    {
        $vote = $this->voteRepository->byId($id);

        return new Vote($vote);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
