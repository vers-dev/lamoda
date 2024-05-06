<?php

namespace App\Contracts\StorageProduct;

use App\Dto\StorageProduct\UpdateStorageProductCountDto;
use App\Dto\StorageProduct\StorageProductDto;

interface StorageProductRepositoryContract
{
    /**
     * @param int $productId
     * @return array<StorageProductDto>
     */
    public function getStorageProductCount(int $productId): array;
}