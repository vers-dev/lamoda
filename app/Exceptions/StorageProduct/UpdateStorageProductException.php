<?php

namespace App\Exceptions\StorageProduct;

use Exception;

class UpdateStorageProductException extends Exception
{
    public function __construct()
    {
        parent::__construct('Cannot update product on storage');
    }
}