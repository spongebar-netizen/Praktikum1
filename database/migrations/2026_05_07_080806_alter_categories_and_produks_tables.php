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
        // 1. Remove produk_id from categories and make name unique
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['produk_id']);
            $table->dropColumn('produk_id');
            $table->unique('name');
        });

        // 2. Add category_id to produks
        Schema::table('produks', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('user_id')->constrained('categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->foreignId('produk_id')->nullable()->constrained('produks')->cascadeOnDelete();
        });
    }
};
