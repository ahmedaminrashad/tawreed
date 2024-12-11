<?php

namespace App\Models;

use File;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'admins';

    protected $guarded = ['id'];

    protected $appends = ['adminRole', 'adminRoleId'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getAdminRoleAttribute()
    {
        return $this->getRoleNames()->first();
    }

    public function getAdminRoleIdAttribute()
    {
        return $this->roles->first()->id;
    }

    public function uploadFile($field, $file)
    {
        $destinationPath = public_path("assets/uploads/admins/$this->id/images/");

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
