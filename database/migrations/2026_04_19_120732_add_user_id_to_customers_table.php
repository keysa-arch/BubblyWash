<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {

            // cek dulu biar tidak error kalau sudah ada
            if (!Schema::hasColumn('customers', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->constrained()
                    ->cascadeOnDelete();
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {

            // drop foreign key dulu
            $table->dropForeign(['user_id']);

            // lalu drop column
            $table->dropColumn('user_id');

        });
    }
};