<?php

namespace App\Exceptions\Product;

use Exception;

class NotEnoughProductsException extends Exception
{

    public function __construct(string $productName)
    {
        parent::__construct("No enough $productName");
    }
}