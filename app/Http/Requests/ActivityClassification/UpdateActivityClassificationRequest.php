<?php

namespace App\Http\Requests\ActivityClassification;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityClassificationRequest extends FormRequest
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
        $validationRules = ['classification_id'=>'required|numeric|exists:classifications,id'];

        foreach (config('langs') as $locale => $name) {
            $validationRules[$locale . "_name"] = ['required', 'string', 'max:255'];
        }

        return $validationRules;
    }
}
