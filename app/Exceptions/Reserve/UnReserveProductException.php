<?php

namespace App\Exceptions\Reserve;

use Exception;

class UnReserveProductException extends Exception
{
    public function __construct(int $productId)
    {
        parent::__construct("Cannot Unreserve product #$productId!");
    }
}