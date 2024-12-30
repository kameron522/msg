<?php

use Illuminate\Support\Facades\Storage;

class ImgDelete
{
    public static function perform(object $obj, string $model): object|bool
    {
        if ($obj && $obj->img) {
            switch ($model) {
                case 'user':
                    if ($obj->id !== auth()->id())
                        return false;
                    break;

                default:
                    if ($obj->user_id !== auth()->id())
                        return false;
                    break;
            }

            Storage::disk('public')->delete($obj->img);
            $obj->img = null;
            $obj->save();
        }
        return $obj;
    }
}
