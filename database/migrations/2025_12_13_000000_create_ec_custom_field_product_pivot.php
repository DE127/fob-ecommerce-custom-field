<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('ec_custom_field_product')) {
            Schema::create('ec_custom_field_product', function (Blueprint $table) {
                $table->unsignedBigInteger('custom_field_id');
                $table->unsignedBigInteger('product_id');

                $table->primary(['custom_field_id', 'product_id']);
                $table->index(['product_id']);

                // Add FKs if tables exist; avoid breaking install order
                if (Schema::hasTable('ec_custom_fields')) {
                    $table->foreign('custom_field_id')->references('id')->on('ec_custom_fields')->onDelete('cascade');
                }
                if (Schema::hasTable('ec_products')) {
                    $table->foreign('product_id')->references('id')->on('ec_products')->onDelete('cascade');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ec_custom_field_product');
    }
};
