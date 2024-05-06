<?php

namespace App\Dto\Reserve;

readonly class ReserveProductDto
{
    public function __construct(
        public int $productId,
        public int $storageId,
        public int $count,
    )
    {
    }
}