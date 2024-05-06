<?php

namespace App\Dto\StorageProduct;

readonly class StorageProductDto
{
    public function __construct(
        public int $productId,
        public int $storageId,
        public int $count,
    )
    {
    }
}