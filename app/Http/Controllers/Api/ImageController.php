<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    /**
     * 保存图片
     *
     * @param Request $request
     * @return resource
     */
    public function store(Request $request)
    {
        $path = $request->file('image')->store('public/images/' . date('Ymd'));

        if (!$path) {
            return response()->json(['message' => '上传失败']);
        }

        return response()->json([
            'message' => '上传成功',
            'path' => $path
        ]);
    }
}
