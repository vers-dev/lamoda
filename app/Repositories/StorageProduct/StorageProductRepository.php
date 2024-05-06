<?php

namespace App\Repositories\StorageProduct;

use App\Contracts\StorageProduct\StorageProductRepositoryContract;
use App\Dto\StorageProduct\UpdateStorageProductCountDto;
use App\Dto\StorageProduct\StorageProductDto;
use App\Exceptions\StorageProduct\UpdateStorageProductException;
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
            ->where('product_id', $productId)
            ->get()
            ->map(fn(StorageProduct $item) => $item->toDto())
            ->toArray();
    }

    /**
     * @throws UpdateStorageProductException
     */
    public function updateProductCount(UpdateStorageProductCountDto $updateProductCountDto): void
    {
        if ($updateProductCountDto->count === 0) {
            $result = StorageProduct::query()
                ->where([
                    'product_id' => $updateProductCountDto->productId,
                    'storage_id' => $updateProductCountDto->storageId
                ])
                ->delete();
        } else {
            $result = StorageProduct::query()
                ->where([
                    'product_id' => $updateProductCountDto->productId,
                    'storage_id' => $updateProductCountDto->storageId
                ])
                ->update(['count' => $updateProductCountDto->count]);
        }

        if (!$result) {
            throw new UpdateStorageProductException();
        }
    }

    public function getProductCountByProductIdAndStorageId(int $productId, int $storageId): int
    {
        return StorageProduct::query()
            ->where([
                'product_id' => $productId,
                'storage_id' => $storageId
            ])
            ->first('count')?->count ?? 0;
    }
}