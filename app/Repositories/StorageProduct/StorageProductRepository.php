<?php

namespace App\Repositories\StorageProduct;

use App\Contracts\StorageProduct\StorageProductRepositoryContract;
use App\Dto\StorageProduct\StorageProductDto;
use App\Models\StorageProduct;

readonly class StorageProductRepository implements StorageProductRepositoryContract
{

    /**
     * @param int $productId
     * @return array<StorageProductDto>
     */
    public function getStorageProductCount(int $productId): array
    {
        return StorageProduct::query()
            ->where("product_id", $productId)
            ->get()
            ->map(fn(StorageProduct $item) => $item->toDto())
            ->toArray();
    }
}