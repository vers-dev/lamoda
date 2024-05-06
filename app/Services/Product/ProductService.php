<?php

namespace App\Services\Product;

use App\Contracts\Product\ProductRepositoryContract;
use App\Contracts\Product\ProductServiceContract;
use App\Contracts\Reserve\ReserveRepositoryContract;
use App\Dto\Product\ProductInfoDto;
use App\Helpers\DBTransactionHelper;

readonly class ProductService implements ProductServiceContract
{
    public function __construct(
        private ProductRepositoryContract        $productRepository,
        private ReserveRepositoryContract        $reserveRepository,
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
                $products = $this->productRepository->getProductInfoByStorageId($storageId);
                foreach ($products as $product) {
                    $reservedProducts = $this->reserveRepository->getReserveCountByProductIdAndStorageId($product->productId, $storageId);

                    $product->reservedProductCount = $reservedProducts;
                    $product->availableProductCount = $product->storageProductCount - $reservedProducts;
                }

                return $products;
            },
            rollback: function () {
            },
            useIsolation: true
        );
    }
}