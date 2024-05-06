<?php

namespace App\Services\Reserve;

use App\Contracts\Product\ProductRepositoryContract;
use App\Contracts\Reserve\ReserveProductServiceContract;
use App\Contracts\Reserve\ReserveRepositoryContract;
use App\Contracts\StorageProduct\StorageProductRepositoryContract;
use App\Dto\Product\UpdateProductCountDto;
use App\Dto\Reserve\ReserveProductDto;
use App\Dto\Reserve\ReserveProductRequestDto;
use App\Dto\StorageProduct\UpdateStorageProductCountDto;
use App\Exceptions\Product\NotEnoughProductsException;
use App\Exceptions\Reserve\UnReserveProductException;
use App\Helpers\DBTransactionHelper;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

readonly class ReserveProductService implements ReserveProductServiceContract
{

    public function __construct(
        private ProductRepositoryContract        $productRepository,
        private StorageProductRepositoryContract $storageProductRepository,
        private ReserveRepositoryContract        $reserveRepository,
    )
    {
    }

    /**
     * @param array<ReserveProductRequestDto> $reservedProducts
     */
    public function reserveProducts(array $reservedProducts): void
    {
        foreach ($reservedProducts as $reservedProduct) {
            DBTransactionHelper::transaction(
                function: function () use ($reservedProduct) {
                    $product = $this->productRepository->getProductById($reservedProduct->productId);
                    $reservedProductCount = $this->reserveRepository->getReserveCountByProductId($reservedProduct->productId);

                    if ($product->count - $reservedProductCount < $reservedProduct->count) {
                        throw new NotEnoughProductsException($product->name);
                    }

                    $storageProducts = $this->storageProductRepository->getStorageProductCount($reservedProduct->productId);

                    $toReserve = $reservedProduct->count;

                    foreach ($storageProducts as $storageProduct) {
                        $reservedCount = $this->reserveRepository->getReserveCountByProductIdAndStorageId($reservedProduct->productId, $storageProduct->storageId);

                        if ($storageProduct->count - $reservedCount >= $toReserve) {
                            $this->reserveRepository->reserveProducts(new ReserveProductDto(
                                productId: $reservedProduct->productId,
                                storageId: $storageProduct->storageId,
                                count: $toReserve
                            ));
                            break;
                        } else {
                            $this->reserveRepository->reserveProducts(new ReserveProductDto(
                                productId: $reservedProduct->productId,
                                storageId: $storageProduct->storageId,
                                count: $storageProduct->count - $reservedCount
                            ));
                            $toReserve -= $storageProduct->count - $reservedCount;
                        }
                    }
                },
                rollback: function (Throwable $throwable) {
                    throw new Exception(message: $throwable->getMessage(), previous: $throwable);
                },
                useIsolation: true
            );
        }
    }

    /**
     * @param array<ReserveProductRequestDto> $unReservedProducts
     */
    public function unReserveProducts(array $unReservedProducts): void
    {
        foreach ($unReservedProducts as $unReservedProduct) {
            DBTransactionHelper::transaction(
                function: function () use ($unReservedProduct) {
                    $reserves = $this->reserveRepository->getReservesByProductId($unReservedProduct->productId);

                    $reservesCount = 0;

                    foreach ($reserves as $reserve) {
                        $reservesCount += $reserve->count;
                    }

                    if ($reservesCount - $unReservedProduct->count < 0) {
                        throw new UnReserveProductException($unReservedProduct->productId);
                    }

                    $toUnreserve = $unReservedProduct->count;

                    foreach ($reserves as $item) {
                        if ($item->count <= $toUnreserve) {
                            $this->reserveRepository->deleteReservation($unReservedProduct->productId, $item->storageId);
                            $toUnreserve -= $item->count;
                        } else {
                            $this->reserveRepository->unReserveProducts(new ReserveProductDto(
                                productId: $unReservedProduct->productId,
                                storageId: $item->storageId,
                                count: $toUnreserve
                            ));
                            break;
                        }
                    }
                },
                rollback: function (Throwable $throwable) {
                    throw new Exception(message: $throwable->getMessage(), previous: $throwable);
                },
                useIsolation: true
            );
        }
    }
}