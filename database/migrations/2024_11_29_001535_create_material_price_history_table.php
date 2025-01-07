<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('material_price_history', function (Blueprint $table) {
            $table->id('price_id');
            $table->foreignId('material_id')->constrained('materials', 'material_id');
            $table->decimal('price_per_dwt', 10, 2);
            $table->date('effective_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_price_history');
    }
};