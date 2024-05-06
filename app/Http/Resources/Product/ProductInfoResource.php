<?php

namespace App\Http\Resources\Product;

use App\Dto\Product\ProductInfoDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class ProductInfoResource extends JsonResource
{

    #[OA\Schema(
        schema: 'ProductInfoResource',
        properties: [
            new OA\Property(
                property: 'product_id',
                description: 'Id Продукта',
                type: 'integer',
            ),
            new OA\Property(
                property: 'product_name',
                description: 'Название продукта',
                type: 'string',
            ),
            new OA\Property(
                property: 'product_size',
                description: 'Размер Продукта',
                type: 'string',
            ),
            new OA\Property(
                property: 'total_product_count',
                description: 'Общее Кол-во Продуктов',
                type: 'integer',
            ),
            new OA\Property(
                property: 'storage_product_count',
                description: 'Кол-во Продуктов На Складе',
                type: 'integer',
            ),
            new OA\Property(
                property: 'reserved_product_count',
                description: 'Кол-во Зарезервированных Продуктов На Складе',
                type: 'integer',
            ),
            new OA\Property(
                property: 'available_product_count',
                description: 'Кол-во Доступных к резервации Продуктов На Складе',
                type: 'integer',
            ),
            new OA\Property(
                property: 'storage_name',
                description: 'Название Склада',
                type: 'string',
            ),
        ],
        type: 'object'
    )]
    public function toArray(Request $request): array
    {
        /** @var ProductInfoDto $this */
        return [
            'product_id' => $this->productId,
            'product_name' => $this->productName,
            'total_product_count' => $this->totalProductCount,
            'storage_product_count' => $this->storageProductCount,
            'reserve_product_count' => $this->reservedProductCount,
            'available_product_count' => $this->availableProductCount,
            'product_size' => $this->productSize,
            'storage_name' => $this->storageName,
        ];
    }
}
