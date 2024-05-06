<?php

namespace Tests\Unit\Product;

use App\Contracts\Product\ProductRepositoryContract;
use App\Exceptions\Product\ProductNotFoundException;
use App\Models\Product;
use App\Models\Storage;
use App\Models\StorageProduct;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private ProductRepositoryContract $productRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepository = $this->app->make(ProductRepositoryContract::class);
    }

    public function testGetProductByIdSuccess(): void
    {
        $product = Product::factory()->create();

        $result = $this->productRepository->getProductById($product->id);

        $this->assertEquals($product->id, $result->id);
    }

    public function testGetProductByIdError(): void
    {
        $this->expectException(ProductNotFoundException::class);

        $result = $this->productRepository->getProductById(999);

        $this->expectExceptionMessage('Product not found');
    }

    public function testGetProductInfo(): void
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

        $result = $this->productRepository->getProductInfoByStorageId($storage1->id);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        foreach ($result as $productInfo) {
            $this->assertEquals($product->id, $productInfo->productId);
            $this->assertEquals(10, $productInfo->storageProductCount);
            $this->assertNull($productInfo->availableProductCount);
            $this->assertNull($productInfo->reservedProductCount);
        }
    }
}