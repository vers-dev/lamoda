<?php

namespace App\Repositories\Product;

use App\Contracts\Product\ProductRepositoryContract;
use App\Dto\Product\ProductDto;
use App\Dto\Product\ProductInfoDto;
use App\Exceptions\Product\ProductNotFoundException;
use App\Models\Product;
use App\Models\Storage;
use App\Models\StorageProduct;
use Illuminate\Support\Facades\DB;

readonly class ProductRepository implements ProductRepositoryContract
{
    /**
     * @param int $storageId
     * @return array<ProductInfoDto>
     */
    public function getProductInfoByStorageId(int $storageId): array
    {
        $productTable = (new Product())->getTable();
        $storageProductTable = (new StorageProduct())->getTable();
        $storageTable = (new Storage())->getTable();

        return Product::query()
            ->select([
                "$productTable.id",
                DB::raw("$productTable.name as product_name"),
                "$productTable.size",
                DB::raw("$productTable.count as product_count"),
                DB::raw("$storageProductTable.count as storage_count"),
                DB::raw("$storageTable.name as storage_name"),
            ])
            ->join($storageProductTable, "$productTable.id", '=', "$storageProductTable.product_id")
            ->join($storageTable, "$storageProductTable.storage_id", '=', "$storageTable.id")
            ->where("$storageProductTable.storage_id", $storageId)
            ->get()
            ->map(function (Product $product) {
                return new ProductInfoDto(
                    productId: $product->id,
                    productName: $product->product_name,
                    productSize: $product->size,
                    storageName: $product->storage_name,
                    totalProductCount: $product->product_count,
                    storageProductCount: $product->storage_count,
                    reservedProductCount: null,
                    availableProductCount: null
                );
            })->toArray();
    }

    /**
     * @throws ProductNotFoundException
     */
    public function getProductById(int $productId): ?ProductDto
    {
        $product = Product::query()
            ->where('id', $productId)
            ->first();

        if (is_null($product)) {
            throw new ProductNotFoundException();
        }

        return $product->toDto();
    }
}