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
        // Ensure the products table exists before altering it. In normal runs the
        // create_products migration will run earlier; this guard makes the
        // migration more robust if someone runs migrations out of order.
        if (Schema::hasTable('products') && !Schema::hasColumn('products', 'seller_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('seller_id')->after('id')->constrained()->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'seller_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['seller_id']);
                $table->dropColumn('seller_id');
            });
        }
    }
};
