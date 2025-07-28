<?php

use App\Models\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

function ordinal_suffix($num)
{
    if ($num == 0) {
        return 0;
    }

    $num = $num % 100; // protect against large numbers
    if ($num < 11 || $num > 13) {
        switch ($num % 10) {
            case 1:
                return $num . 'st';
            case 2:
                return $num . 'nd';
            case 3:
                return $num . 'rd';
        }
    }
    return $num . 'th';
}
function uploadFile($file): Model|Builder|null
{
    $destinationPath = File::$uploads_path;
    $upload_success = Storage::disk('public')->put($destinationPath, $file);
    info($upload_success);
    if ($upload_success) {
        return File::query()->create(['url' => basename($upload_success)]);
    }

    return null;


}

function isImage($string)
{
    $extension = pathinfo($string, PATHINFO_EXTENSION);
    return in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg']);
}

