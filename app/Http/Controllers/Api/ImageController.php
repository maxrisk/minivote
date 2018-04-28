<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('token.refresh');
    }

    /**
     * 保存图片
     *
     * @param Request $request
     * @return resource
     */
    public function store(Request $request)
    {
        $image = $request->file('image');
        if (! in_array(strtolower($image->getClientOriginalExtension()),
            ['jpg', 'jpeg', 'png'])) {
            return response()->json(['message' => '文件格式不支持']);
        }

        if ($image->isValid()) {
            $path = $request->file('image')->store('public/images/' . date('Ymd'));

            if (!$path) {
                return response()->json(['message' => '上传失败']);
            }

            return response()->json([
                'message' => '上传成功',
                'path' => $path,
                'host' => url('/')
            ]);
        }

        return response()->json(['message' => '上传失败']);
    }
}
