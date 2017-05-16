<?php

namespace App\Http\Controllers\Admin;

use Ramsey\Uuid\Uuid;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UploadFilesController extends AdminController
{
    public function store(Request $request, $type = '')
    {
        switch ($type) {
            case 'images':
                return $this -> uploadImages($request);
                break;
            default:
                return abort(404);
                break;
        }
    }

    private function uploadImages(Request $request)
    {
        $roles = ['images' => 'required|mimes:jpeg,bmp,png,jpg,gif|max:3145728'];
        $message = [
            'required' => '请选择要上传的图片',
            'mimes' => '图片格式不正确，仅支持jpeg,bmp,png,jpg,gif！',
            'max' => '图片文件最大为3M！',
        ];
        try {
            $this -> validate($request, $roles, $message);
        } catch (ValidationException $e) {
            $error = $e -> validator -> getMessageBag() -> first();
            return sprintf('error|%s', $error);
        }
        if ($request -> hasFile('images')) {
            $waterMarkFontSize = 14;
            $relativeDirPath = '/images/posts/' . date('Ymd');
            $absoluteDirPath = storage_path('app/public') . $relativeDirPath;
            $this -> makeDir($absoluteDirPath);
            $filename = Uuid::uuid1() -> toString() . '.' . $request->images->extension();
            $img = Image::make($request -> images);
            $img -> text(env('APP_NAME'), $img -> width() - 10, $img -> height() - ($waterMarkFontSize + 3),
            function($font) use ($waterMarkFontSize) {
                $font->file(storage_path('app/local/fonts') . '/msyh.ttf');
                $font->size($waterMarkFontSize);
                $font->color('#FFFFFF');
                $font->align('right');
                $font->valign('bottom');
            });
            $img -> text('@' . env('APP_URL'), $img -> width() - 10, $img -> height(),
            function($font) use ($waterMarkFontSize) {
                $font->file(storage_path('app/local/fonts') . '/msyh.ttf');
                $font->size($waterMarkFontSize);
                $font->color('#FFFFFF');
                $font->align('right');
                $font->valign('bottom');
            });
            $relativeFilePath = $relativeDirPath . '/' . $filename;
            $img -> save($absoluteDirPath . '/' . $filename);
            $url = env('IMG_SERVER') . $relativeFilePath;
            return $url;
        } else {
            return 'error|图片不存在';
        }
    }

    private function makeDir($dir = '')
    {
        return  is_dir ( $dir ) or $this -> makeDir(dirname( $dir )) and  mkdir ( $dir , 0777);
    }

}
