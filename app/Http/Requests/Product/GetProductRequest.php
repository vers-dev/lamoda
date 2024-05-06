<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class GetProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'storage_id' => ['required', 'integer'],
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
