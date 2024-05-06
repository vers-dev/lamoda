<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        DB::table('storage_products')->insert([
            [
                'product_id' => 1,
                'storage_id' => 2,
                'count' => 50,
            ],
            [
                'product_id' => 1,
                'storage_id' => 1,
                'count' => 50,
            ],
            [
                'product_id' => 2,
                'storage_id' => 2,
                'count' => 150,
            ],
            [
                'product_id' => 3,
                'storage_id' => 1,
                'count' => 10,
            ],
            [
                'product_id' => 3,
                'storage_id' => 3,
                'count' => 10,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::table('', function (Blueprint $table) {
            //
        });
    }
};
