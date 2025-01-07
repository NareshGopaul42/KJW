<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id('material_id');
            $table->string('name', 100);
            $table->string('sub_category', 50);
            $table->decimal('current_stock', 10, 3);
            $table->decimal('minimum_threshold', 10, 3);
            $table->string('unit', 10)->default('dwt');
            $table->string('status', 20)->default('In Stock');
            $table->decimal('cost_per_dwt', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
};