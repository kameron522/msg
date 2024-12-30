<?php

namespace App\Base\Packages;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImgUpload
{
    public static function perform(Request $request, string $model, object $obj = null)
    {
        $inputs = $request->validated();
        if($obj && $obj->img)
            Storage::disk('public')->delete($obj->img);
        if($request->has('img'))
        {
            $image_path = $request->file('img')->store($model.'_images', 'public');
            $inputs['img'] = $image_path;
        }
        return $inputs;
    }
}
