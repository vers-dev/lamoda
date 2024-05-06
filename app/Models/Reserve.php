<?php

namespace App\Models;

use App\Dto\Reserve\ReserveDto;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{

    protected $fillable = [
        'product_id',
        'storage_id',
        'count'
    ];

    public function toDto(): ReserveDto
    {
        return new ReserveDto(
            productId: $this->product_id,
            storageId: $this->storage_id,
            count: $this->count
        );
    }
}
