<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customer_materials', function (Blueprint $table) {
            $table->id('receipt_id');
            $table->foreignId('customer_id')->constrained('customers', 'customer_id');
            $table->foreignId('material_id')->constrained('materials', 'material_id');
            $table->decimal('weight_dwt', 10, 3);
            $table->date('date_received');
            $table->string('status', 50)->default('Received');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_materials');
    }
};