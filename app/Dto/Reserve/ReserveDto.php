<?php

namespace App\Dto\Reserve;

readonly class ReserveDto
{
    public function __construct(
        public int $productId,
        public int $storageId,
        public int $count,
    )
    {
    }
}