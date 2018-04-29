<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
                'path' => substr($path, '6'),
                'host' => url('/')
            ]);
        }

        return response()->json(['message' => '上传失败']);
    }

    /**
     * 删除图片
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $image = Image::find($id);

        Storage::delete('public' . $image->path);

        $deleted = $image->delete();

        if ($deleted) {
            return response()->json(['message' => 'Deleted successfully']);
        }

        return response()->json(['message' => 'Delete failed']);
    }
}
