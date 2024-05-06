<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        DB::table('storages')->insert([
            [
                'name' => 'Первый склад',
                'is_active' => true,
            ],
            [
                'name' => 'Второй склад',
                'is_active' => true,
            ],
            [
                'name' => 'Третий склад',
                'is_active' => true,
            ]
        ]);
    }

    public function down(): void
    {
    }
};
