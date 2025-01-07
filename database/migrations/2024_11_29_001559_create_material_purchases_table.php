<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('material_purchases', function (Blueprint $table) {
            $table->id('purchase_id');
            $table->foreignId('seller_id')->constrained('sellers', 'seller_id');
            $table->foreignId('material_id')->constrained('materials', 'material_id');
            $table->decimal('weight_dwt', 10, 3);
            $table->decimal('purchase_price_per_dwt', 10, 2);
            $table->decimal('total_cost', 10, 2);
            $table->date('date_purchased');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_purchases');
    }
};