<?php

namespace App\Exceptions\Storage;

use Exception;

class StorageUnavailableException extends Exception
{
    public function __construct()
    {
        parent::__construct('Storage Currently Unavailable');
    }
}