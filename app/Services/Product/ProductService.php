<?php

namespace App\Services\Product;

use App\Contracts\Product\ProductRepositoryContract;
use App\Contracts\Product\ProductServiceContract;
use App\Contracts\Reserve\ReserveRepositoryContract;
use App\Contracts\Storage\StorageRepositoryContract;
use App\Dto\Product\ProductInfoDto;
use App\Exceptions\Storage\StorageUnavailableException;
use App\Helpers\DBTransactionHelper;
use Exception;
use Throwable;

readonly class ProductService implements ProductServiceContract
{
    public function __construct(
        private ProductRepositoryContract $productRepository,
        private ReserveRepositoryContract $reserveRepository,
        private StorageRepositoryContract $storageRepository,
    )
    {
    }

    /**
     * @param int $storageId
     * @return array<ProductInfoDto>
     */
    public function getProductsByStorageId(int $storageId): array
    {
        return DBTransactionHelper::transaction(
            function: function () use ($storageId) {
                if (!$this->storageRepository->isActiveStorage($storageId)) {
                    throw new StorageUnavailableException();
                }

                $products = $this->productRepository->getProductInfoByStorageId($storageId);

                foreach ($products as $product) {
                    $reservedProducts = $this->reserveRepository->getReserveCountByProductIdAndStorageId($product->productId, $storageId);

                    $product->reservedProductCount = $reservedProducts;
                    $product->availableProductCount = $product->storageProductCount - $reservedProducts;
                }

                return $products;
            },
            rollback: function (Throwable $throwable) {
                throw new Exception(message: $throwable->getMessage(), previous: $throwable);
            },
            useIsolation: true
        );
    }
}