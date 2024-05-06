<?php

namespace Tests\Unit\Reserve;

use App\Contracts\Reserve\ReserveRepositoryContract;
use App\Dto\Reserve\ReserveDto;
use App\Dto\Reserve\ReserveProductDto;
use App\Models\Product;
use App\Models\Reserve;
use App\Models\Storage;
use App\Models\StorageProduct;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReserveRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private ReserveRepositoryContract $reserveRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reserveRepository = $this->app->make(ReserveRepositoryContract::class);
    }

    public function testDeleteReservation(): void
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

        $this->reserveRepository->deleteReservation($product->id, $storage1->id);

        $status = Reserve::query()->where(['storage_id' => $storage1->id, 'product_id' => $product->id])->doesntExist();

        $this->assertTrue($status);
    }

    public function testGetReserveCountByProductId(): void
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

        $count = $this->reserveRepository->getReserveCountByProductId($product->id);

        $this->assertIsInt($count);
        $this->assertEquals(5, $count);
    }

    public function testGetReservesByProductId(): void
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

        $result = $this->reserveRepository->getReservesByProductId($product->id);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);

        foreach ($result as $reserve) {
            $this->assertInstanceOf(ReserveDto::class, $reserve);
            $this->assertEquals(5, $reserve->count);
        }
    }

    public function testGetReservesCountByProductIdAndStorageId(): void
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

        $result = $this->reserveRepository->getReserveCountByProductIdAndStorageId($product->id, $storage1->id);

        $this->assertIsInt($result);
        $this->assertEquals(5, $result);
    }

    public function testReserveProduct(): void
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

        $this->reserveRepository->reserveProducts(new ReserveProductDto(
            productId: $product->id,
            storageId: $storage1->id,
            count: 10
        ));

        $reserve = $this->reserveRepository->getReserveCountByProductIdAndStorageId($product->id, $storage1->id);

        $this->assertEquals(10, $reserve);
    }

    public function testUnReserveProduct(): void
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

        $this->reserveRepository->unReserveProducts(new ReserveProductDto(
            productId: $product->id,
            storageId: $storage1->id,
            count: 4
        ));

        $exists = Reserve::query()->where(['storage_id' => $storage1->id, 'product_id' => $product->id])->exists();

        $this->assertTrue($exists);
    }


}