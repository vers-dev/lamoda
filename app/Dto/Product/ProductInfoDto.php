<?php

namespace App\Dto\Product;

class ProductInfoDto
{

    public function __construct(
        public readonly int    $productId,
        public readonly string $productName,
        public readonly string $productSize,
        public readonly string $storageName,
        public readonly int    $totalProductCount,
        public readonly int    $storageProductCount,
        public ?int            $reservedProductCount,
        public ?int            $availableProductCount,
    )
    {
    }
}