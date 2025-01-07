<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('material_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials', 'material_id');
            $table->decimal('quantity', 10, 3);
            $table->date('receipt_date');
            $table->decimal('cost_per_unit', 10, 2);
            $table->string('entity_name', 100)->nullable();  // Instead of just 'supplier'
            $table->enum('receipt_type', ['purchase', 'custom_order', 'sale_to_store']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_receipts');
    }
};
