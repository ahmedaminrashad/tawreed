<?php

namespace App\Http\Requests\Tender;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenderItemRequest extends FormRequest
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
        return [
            "item" => ["required", "array"],
            "item.*.name" => ["required", "string", "max:255"],
            "item.*.quantity" => ["required", "numeric", 'min:1', 'regex:/^[0-9]+$/'],
            "item.*.unit_id" => ["required", "numeric", 'exists:units,id'],
            "item.*.specs" => ["nullable", "string", 'max:3000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'unit_id' => 'Measurment Unit',
            'specs' => 'Technical Specifications',
        ];
    }

    public function withValidator($validator)
    {
        // $validator->after(function ($validator) {
        //     $totalSize = 0;

        //     if ($this->has('files')) {
        //         foreach ($this->file('files') as $file) {
        //             $totalSize += $file->getSize();
        //         }
        //     }

        //     // Check if the total size exceeds 50 MB
        //     if ($totalSize > 50 * 1024 * 1024) {
        //         $validator->errors()->add('files', 'The total size of all files must not exceed 50 MB.');
        //     }
        // });
    }
}
