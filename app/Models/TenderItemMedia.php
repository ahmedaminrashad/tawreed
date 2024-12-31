<?php

namespace App\Models;

use File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderItemMedia extends Model
{
    use HasFactory;

    public $table = 'tender_item_media';

    protected $guarded = ['id'];

    public function uploadFile($field, $file)
    {
        $destinationPath = public_path("assets/uploads/tenders/$this->tender_id/items/$this->tender_item_id/media/");

        if (!is_dir($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }

        if ($this->$field && file_exists($destinationPath)) {
            File::delete($destinationPath . $this->$field);
        }

        $fileName = $file->getClientOriginalName();
        $fileName = str_replace(" ", "_", $fileName);
        $fileName = strtotime(date('Y-m-d H:i:s')) . '_' . $fileName;

        $file->move($destinationPath, $fileName);

        $this->$field = $fileName;
        $this->save();
    }
}
