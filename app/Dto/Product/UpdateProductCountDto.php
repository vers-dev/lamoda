<?php

namespace App\Dto\Product;

readonly class UpdateProductCountDto
{
    public function __construct(
        public int  $productId,
        public int  $count
    )
    {
    }
}