<?php

namespace App\Http\Resources;

use App\Enums\UserType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->type == UserType::INDIVIDUAL->value) {
            $data = [
                'full_name' => $this->full_name,
            ];
        } else if ($this->type == UserType::COMPANY->value) {
            $data = [
                'company_name' => $this->comapny_name,
                'commercial_registration_number' => $this->commercial_registration_number,
            ];
        }

        $data = [
            'id' => $this->id,
            'type' => $this->type->value,
            'email' => $this->email,
            'country' => $this->country->translate('ar')->name,
            'is_verified' => $this->email_verified_at ? true : false,
            "created_at" => Carbon::parse($this->created_at)->format('Y-m-d'),
            "updated_at" => Carbon::parse($this->updated_at)->format('Y-m-d'),
        ];

        return $data;
    }
}
