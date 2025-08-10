<?php

use App\Enums\ProposalStatus;
use App\Models\File;
use App\Models\TenderItemMedia;
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

function deleteFileItem($media): string
{
    try {
        if (Storage::disk('public')->exists($media->file)) {
            Storage::disk('public')->delete($media->file);
        }
        return $media->delete() ? 'success' : 'error';
    } catch (\Exception $e) {
        return 'error';
    }
}

function userHaveProposal($tender): bool
{

    if ($tender->user_id == auth()->id())
        return false;
    return in_array(auth()->id(), $tender->proposals()->whereNotIn('status',[ProposalStatus::WITHDRAWN->value,ProposalStatus::REJECTED->value])->pluck('user_id')->toArray());

}
