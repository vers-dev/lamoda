<?php

namespace App\Dto\Product;

readonly class ProductDto
{

    public function __construct(
        public int    $id,
        public string $name,
        public string $size,
        public int    $count,
    )
    {
    }
}