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

    public function scopeActive($query)
    {
        return $query->where('is_active', 'T');
    }
}
