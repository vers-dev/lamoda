<?php

namespace App\Exceptions\Reserve;

use Exception;

class ReserveProductException extends Exception
{
    public function __construct()
    {
        parent::__construct('Cannot reserve product!');
    }
}