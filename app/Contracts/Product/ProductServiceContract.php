<?php

namespace App\Contracts\Product;

use App\Dto\Product\ProductDto;
use App\Dto\Product\ProductInfoDto;

interface ProductServiceContract
{

    /**
     * @param int $storageId
     * @return array<ProductInfoDto>
     */
    public function getProductsByStorageId(int $storageId): array;
}