<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('stocks', function (Blueprint $table) {
            $table->string('base_unit')->default('pcs')->after('unit'); // g, pcs, etc.
            $table->decimal('conversion_factor', 10, 3)->default(1)->after('base_unit'); // 1 kg = 1000 g
        });
    }

    public function down(): void {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn(['base_unit', 'conversion_factor']);
        });
    }
};
