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

    public function votes()
    {
        return $this->hasMany(VoteOption::class);
    }

    public function voteFor($option, $voteId)
    {
        return $this->voteOption()->attach($option, ['vote_id' => $voteId]);
    }

    public function hadVoteFor($voteId)
    {
        return $this->votes()->where('vote_id', $voteId)->first();
    }
}
