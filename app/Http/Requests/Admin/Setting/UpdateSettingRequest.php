<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->setting->key == 'commission' || $this->setting->key == 'vat') {
            $result = [
                'value' => ['required', 'numeric', 'min:0', 'max:100'],
            ];
        } else if ($this->setting->key == 'phone') {
            $result = [
                'value' => ['required', 'string', 'max:255'],
            ];
        } else if ($this->setting->key == 'review') {
            $result = [
                'value' => ['nullable', 'numeric', 'min:0', 'max:1'],
            ];
        } else if ($this->setting->key == 'email') {
            $result = [
                'value' => ['required', 'email', 'max:255'],
            ];
        } else if (str_contains($this->setting->key, 'link')) {
            $result = [
                'value' => ['required', 'string', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
            ];
        }

        return $result;
    }
}
