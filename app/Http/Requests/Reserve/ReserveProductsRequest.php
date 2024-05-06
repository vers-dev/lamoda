<?php

namespace App\Http\Requests\Reserve;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

class ReserveProductsRequest extends FormRequest
{

    #[OA\Schema(
        schema: 'ReserveProductsRequest',
        properties: [
            new OA\Property(
                property: 'products',
                type: 'array',
                items: new OA\Items(
                    properties: [
                        new OA\Property(
                            property: 'product_id',
                            description: 'ID Продукта',
                            type: 'integer',
                            example: 1,
                        ),
                        new OA\Property(
                            property: 'count',
                            description: 'Кол-во продукта',
                            type: 'integer',
                            minimum: 1,
                            example: 10
                        ),
                    ]
                ),
                nullable: false
            ),
        ],
        type: 'object'
    )]

    public function rules(): array
    {
        return [
            'products' => ['required', 'array'],
            'products.*.product_id' => ['required', 'integer'],
            'products.*.count' => ['required', 'integer', 'min:1'],
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
