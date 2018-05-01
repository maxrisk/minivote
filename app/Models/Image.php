<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = ['vote_id', 'path'];

    /**
     * 删除图片
     */
    public function unlink()
    {
        Storage::delete('public' . substr($this->path, 8));
    }
}
