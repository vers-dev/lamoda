<?php

namespace App\Dto\StorageProduct;

readonly class UpdateStorageProductCountDto
{

    public function __construct(
        public int  $productId,
        public ?int $storageId,
        public int  $count
    )
    {
    }
}