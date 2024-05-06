<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reserves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_id')->constrained('storages');
            $table->foreignId('product_id')->constrained('products');
            $table->unsignedInteger('count');
            $table->timestamps();

            $table->unique(['product_id', 'storage_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserves');
    }
};
