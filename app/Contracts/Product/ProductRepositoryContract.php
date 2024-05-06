<?php

namespace App\Contracts\Product;

use App\Dto\Product\ProductDto;
use App\Dto\Product\ProductInfoDto;

interface ProductRepositoryContract
{

    /**
     * @param int $storageId
     * @return array<ProductInfoDto>
     */
    public function getProductInfoByStorageId(int $storageId): array;


    public function getProductById(int $productId): ?ProductDto;

}