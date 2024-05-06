<?php

namespace App\Models;

use App\Dto\StorageProduct\StorageProductDto;
use Illuminate\Database\Eloquent\Model;

class StorageProduct extends Model
{
    public $timestamps = false;

    public function toDto(): StorageProductDto
    {
        return new StorageProductDto(
            productId: $this->product_id,
            storageId: $this->storage_id,
            count: $this->count
        );
    }
}
