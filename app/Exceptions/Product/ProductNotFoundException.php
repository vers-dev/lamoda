<?php

namespace App\Exceptions\Product;

use Exception;

class ProductNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct("Product not found");
    }
}