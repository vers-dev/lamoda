<?php

namespace App\Exceptions\Product;

use Exception;

class UpdateProductException extends Exception
{
    public function __construct()
    {
        parent::__construct('Failed to update product.');
    }
}