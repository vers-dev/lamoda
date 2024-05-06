<?php

namespace App\Contracts\Storage;

interface StorageRepositoryContract
{
    public function isActiveStorage(int $storageId): bool;
}