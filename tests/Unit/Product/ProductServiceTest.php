<?php

namespace Tests\Unit\Product;

use App\Contracts\Product\ProductServiceContract;
use App\Models\Product;
use App\Models\Reserve;
use App\Models\Storage;
use App\Models\StorageProduct;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
//    use DatabaseTransactions;

    private ProductServiceContract $productRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepository = $this->app->make(ProductServiceContract::class);
    }

    public function testGetProductsByStorageId(): void
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

        Reserve::factory()->create([
            'storage_id' => $storage1->id,
            'product_id' => $product->id,
            'count' => 5
        ]);
        Reserve::factory()->create([
            'storage_id' => $storage2->id,
            'product_id' => $product->id,
            'count' => 5
        ]);

        $result = $this->productRepository->getProductsByStorageId($storage1->id);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);

        foreach ($result as $item) {
            $this->assertEquals(5, $item->reservedProductCount);
            $this->assertEquals(5, $item->availableProductCount);
        }
    }
}