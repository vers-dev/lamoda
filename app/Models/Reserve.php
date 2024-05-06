<?php

namespace App\Models;

use App\Dto\Reserve\ReserveDto;
use Database\Factories\ReserveFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;

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

    protected static function newFactory(): ReserveFactory
    {
        return ReserveFactory::new();
    }
}
