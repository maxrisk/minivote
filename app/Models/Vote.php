<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id', 'title', 'content', 'is_private', 'is_active'];

    public function options()
    {
        return $this->hasMany(Option::class);
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
}
