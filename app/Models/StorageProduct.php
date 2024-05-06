<?php

namespace App\Models;

use App\Dto\StorageProduct\StorageProductDto;
use Database\Factories\StorageProductFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageProduct extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function toDto(): StorageProductDto
    {
        return new StorageProductDto(
            productId: $this->product_id,
            storageId: $this->storage_id,
            count: $this->count
        );
    }

    protected static function newFactory(): StorageProductFactory
    {
        return StorageProductFactory::new();
    }
}
