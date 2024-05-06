<?php

namespace App\Contracts\Reserve;

use App\Dto\Reserve\ReserveDto;
use App\Dto\Reserve\ReserveProductDto;

interface ReserveRepositoryContract
{

    public function reserveProducts(ReserveProductDto $reserveProductDto): void;

    public function unReserveProducts(ReserveProductDto $reserveProductDto): void;

    public function deleteReservation(int $productId, int $storageId): void;

    public function getReserveCountByProductId(int $productId): int;

    /**
     * @param int $productId
     * @return array<ReserveDto>
     */
    public function getReservesByProductId(int $productId): array;

    public function getReserveCountByProductIdAndStorageId(int $productId, int $storageId): int;
}