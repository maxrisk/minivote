<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'openid', 'nick_name', 'avatar_url', 'gender', 'city', 'province', 'country', 'language',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function voteOption()
    {
        return $this->belongsToMany(VoteOption::class, 'vote_option', 'user_id', 'option_id')->withTimestamps();
    }

    public function voteOptions()
    {
        return $this->hasMany(VoteOption::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * 给某个选项投票
     *
     * @param string $option 选项ID
     * @param string $voteId 投票的ID
     */
    public function voteFor($option, $voteId)
    {
        return $this->voteOption()->attach($option, ['vote_id' => $voteId]);
    }

    /**
     * 查询当前用户是否为某用户投票
     *
     * @param $voteId
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function hadVoteFor($voteId)
    {
        return $this->voteOptions()->where('vote_id', $voteId)->first();
    }

    /**
     * 获取当前用户所有投票
     *
     * @return mixed
     */
    public function allVotes()
    {
        return $this->votes()->active()->notPrivate()->paginate(10);
    }


    /**
     * 按 ID 删除用户发起的投票
     *
     * @param $id
     * @return bool|mixed|null
     */
    public function deleteVote($id)
    {
        $vote = $this->votes()->where('id', $id)->first();

        if (! $vote) {
            return false;
        }

        return $vote->delete();
    }
}
