<?php

namespace App\Models;

use App\Dto\Product\ProductDto;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function toDto(): ProductDto
    {
        return new ProductDto(
            id: $this->id,
            name: $this->name,
            size: $this->size,
            count: $this->count,
        );
    }

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
