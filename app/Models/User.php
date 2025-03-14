<?php

namespace App\Models;

use App\Enums\UserType;
use Carbon\Carbon;
use File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'type' => UserType::class,
    ];

    protected $appends = ['phone_number', 'created_date', 'user_type', 'displayed_name'];

    public function getDisplayedNameAttribute()
    {
        return $this->isCompany() ? $this->company_name : $this->full_name;
    }

    public function getUserTypeAttribute()
    {
        return ucfirst($this->type->value);
    }

    public function getPhoneNumberAttribute()
    {
        return $this->country_code . '-' . $this->phone;
    }

    public function getCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function userDevices(): HasMany
    {
        return $this->hasMany(UserDevice::class, 'user_id', 'id');
    }

    public function userCategories(): BelongsToMany
    {
        return $this->belongsToMany(WorkCategoryClassification::class, 'user_categories', 'user_id', 'category_id');
    }

    public function userCategoriesName()
    {
        return $this->userCategories()->join('classification_translations', 'classifications.id', 'classification_translations.classification_id')
            ->select('classifications.id as category_id', 'classification_translations.name as category_name')
            ->pluck('category_name', 'category_id')->toArray();
    }

    public function userCategoriesNameForShow()
    {
        return implode(", ", $this->userCategoriesName());
    }

    public function isCompany(): bool
    {
        return $this->type->value == UserType::COMPANY->value;
    }

    public function isIndividual(): bool
    {
        return $this->type->value == UserType::INDIVIDUAL->value;
    }

    public function uploadImage($file)
    {
        $destinationPath = public_path("assets/uploads/users/$this->id/images/");

        if (!is_dir($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }

        if ($this->image && file_exists($destinationPath)) {
            File::delete($destinationPath . $this->image);
        }

        $fileName = $file->getClientOriginalName();
        $fileName = str_replace(" ", "_", $fileName);
        $fileName = strtotime(date('Y-m-d H:i:s')) . '_' . $fileName;

        $file->move($destinationPath, $fileName);

        $this->image = $fileName;
        $this->save();
    }

    public function uploadFile($field, $file)
    {
        $destinationPath = public_path("assets/uploads/users/$this->id/files/");

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
