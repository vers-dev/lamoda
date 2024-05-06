<?php

namespace App\Repositories\Reserve;

use App\Contracts\Reserve\ReserveRepositoryContract;
use App\Dto\Reserve\ReserveProductDto;
use App\Exceptions\Reserve\ReserveProductException;
use App\Exceptions\Reserve\UnReserveProductException;
use App\Models\Reserve;
use Illuminate\Support\Facades\DB;

readonly class ReserveRepository implements ReserveRepositoryContract
{

    /**
     * @param ReserveProductDto $reserveProductDto
     * @return void
     * @throws ReserveProductException
     */
    public function reserveProducts(ReserveProductDto $reserveProductDto): void
    {
        if (Reserve::query()->where([
            'product_id' => $reserveProductDto->productId,
            'storage_id' => $reserveProductDto->storageId
        ])->exists()) {
            $result = Reserve::query()
                ->where([
                    'product_id' => $reserveProductDto->productId,
                    'storage_id' => $reserveProductDto->storageId
                ])->update([
                    'count' => DB::raw("count + $reserveProductDto->count")
                ]);
        } else {
            $result = Reserve::query()->create([
                'product_id' => $reserveProductDto->productId,
                'storage_id' => $reserveProductDto->storageId,
                'count' => $reserveProductDto->count
            ]);
        }

        if (!$result) {
            throw new ReserveProductException();
        }
    }

    /**
     * @param ReserveProductDto $reserveProductDto
     * @return void
     * @throws UnReserveProductException
     */
    public function unReserveProducts(ReserveProductDto $reserveProductDto): void
    {
        $result = Reserve::query()
            ->where([
                'product_id' => $reserveProductDto->productId,
                'storage_id' => $reserveProductDto->storageId
            ])->update([
                'count' => DB::raw("count - $reserveProductDto->count")
            ]);

        if (!$result) {
            throw new UnReserveProductException($reserveProductDto->productId);
        }
    }

    /**
     * @throws UnReserveProductException
     */
    public function deleteReservation(int $productId, int $storageId): void
    {
        $result = Reserve::query()
            ->where([
                'product_id' => $productId,
                'storage_id' => $storageId
            ])->delete();

        if (!$result) {
            throw new UnReserveProductException($productId);
        }
    }

    public function getReserveCountByProductId(int $productId): int
    {
        return Reserve::query()
            ->where('product_id', $productId)
            ->groupBy('product_id')
            ->sum('count');
    }

    public function getReservesByProductId(int $productId): array
    {
        return Reserve::query()
            ->where(['product_id' => $productId])
            ->get()
            ->map(fn (Reserve $reserve) => $reserve->toDto())
            ->toArray();
    }

    public function getReserveCountByProductIdAndStorageId(int $productId, int $storageId): int
    {
        return Reserve::query()
            ->where(['product_id' => $productId, 'storage_id' => $storageId])
            ->first('count')?->count ?? 0;
    }

}