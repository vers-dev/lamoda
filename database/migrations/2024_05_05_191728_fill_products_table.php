<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Футболка Белая',
                'size' => 'M',
                'count' => 100,
            ],
            [
                'name' => 'Футболка Черная',
                'size' => 'L',
                'count' => 150,
            ],
            [
                'name' => 'Футболка Синяя',
                'size' => 'L',
                'count' => 20,
            ],
        ]);
    }

    public function down(): void
    {
    }
};
