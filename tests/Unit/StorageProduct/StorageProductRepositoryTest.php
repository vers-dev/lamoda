<?php

namespace Tests\Unit\StorageProduct;

use App\Contracts\StorageProduct\StorageProductRepositoryContract;
use App\Models\Product;
use App\Models\Storage;
use App\Models\StorageProduct;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StorageProductRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private StorageProductRepositoryContract $storageProductRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->storageProductRepository = $this->app->make(StorageProductRepositoryContract::class);
    }

    public function testGetProductsInStorages()
    {
        $storage1 = Storage::factory()->create();
        $storage2 = Storage::factory()->create();

        $product = Product::factory()->create(['count' => 20]);

        StorageProduct::factory()->create([
            'storage_id' => $storage1->id,
            'product_id' => $product->id,
            'count' => 10
        ]);
        StorageProduct::factory()->create([
            'storage_id' => $storage2->id,
            'product_id' => $product->id,
            'count' => 10
        ]);

        $result = $this->storageProductRepository->getStorageProductCount($product->id);

        $this->assertCount(2, $result);

        foreach ($result as $item) {
            $this->assertEquals(10, $item->count);
            $this->assertEquals($product->id, $item->productId);
        }
    }
}