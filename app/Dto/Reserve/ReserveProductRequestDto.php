<?php

namespace App\Dto\Reserve;

readonly class ReserveProductRequestDto
{

    public function __construct(
        public int $productId,
        public int $count,
    )
    {
    }
}