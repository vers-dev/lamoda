<?php

namespace App\Contracts\Product;

use App\Dto\Product\ProductDto;

interface ProductServiceContract
{

    /**
     * @param int $storageId
     * @return array<ProductDto>
     */
    public function getProductsByStorageId(int $storageId): array;
}