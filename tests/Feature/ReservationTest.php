<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Reserve;
use App\Models\Storage;
use App\Models\StorageProduct;
use Tests\TestCase;

class ReservationTest extends TestCase
{

    public function testCreateReservationSuccess(): void
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

        $response = $this->post(route('reserve-products'), [
            'products' => [
                [
                    'product_id' => $product->id,
                    'count' => 10
                ]
            ]
        ]);

        $response->assertOk();

        $data = $response->json();

        $this->assertEquals("Products Successful Reserved.", $data['message']);
    }

    public function testCreateReservationError(): void
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

        $response = $this->post(route('reserve-products'), [
            'products' => [
                [
                    'product_id' => $product->id,
                    'count' => 50
                ]
            ]
        ]);

        $response->assertStatus(500);

        $data = $response->json();

        $this->assertEquals("No enough $product->name", $data['error']);
    }

    public function testUnReservationSuccess(): void
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

        $response = $this->post(route('un-reserve-products'), [
            'products' => [
                [
                    'product_id' => $product->id,
                    'count' => 5
                ]
            ]
        ]);

        $response->assertOk();

        $data = $response->json();

        $this->assertEquals("Products Successful UnReserved.", $data['message']);
    }

    public function testUnReservationError(): void
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

        $response = $this->post(route('un-reserve-products'), [
            'products' => [
                [
                    'product_id' => $product->id,
                    'count' => 50
                ]
            ]
        ]);

        $response->assertStatus(500);

        $data = $response->json();

        $this->assertEquals("Cannot Unreserve product #$product->id!", $data['error']);
    }

}