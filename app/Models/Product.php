<?php

namespace App\Models;

use App\Dto\Product\ProductDto;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public function toDto(): ProductDto
    {
        return new ProductDto(
            id: $this->id,
            name: $this->name,
            size: $this->size,
            count: $this->count,
        );
    }
}
