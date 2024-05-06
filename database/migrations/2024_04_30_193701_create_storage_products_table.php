<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('storage_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('storage_id')->constrained('storages');
            $table->unsignedInteger('count');

            $table->unique(['product_id', 'storage_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('storage_products');
    }
};
