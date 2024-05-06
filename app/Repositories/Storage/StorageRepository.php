<?php

namespace App\Repositories\Storage;

use App\Contracts\Storage\StorageRepositoryContract;
use App\Models\Storage;

readonly class StorageRepository implements StorageRepositoryContract
{

    public function isActiveStorage(int $storageId): bool
    {
        return Storage::query()
            ->where('id', $storageId)
            ->first()?->is_active ?? false;
    }
}