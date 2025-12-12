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
        Schema::create('rating_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('no_telp');
            $table->integer('rating');
            $table->text('review')->nullable();
            $table->unsignedBigInteger('product_detail_id');
            $table->unsignedBigInteger('region_id');
            $table->timestamps();
            
            $table->foreign('product_detail_id')->references('id')->on('product_details')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('region')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rating_reviews', function (Blueprint $table) {
            $table->dropForeign(['product_detail_id']);
            $table->dropForeign(['region_id']);
        });
        Schema::dropIfExists('rating_reviews');
    }
};