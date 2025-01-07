<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('material_tracking', function (Blueprint $table) {
            $table->id();
            $table->string('material_id');
            $table->string('batch_number');
            $table->string('customer');
            $table->decimal('amount_received', 10, 2);
            $table->datetime('date_received');
            $table->string('unit_of_measure')->default('dwt');
            $table->string('storage');
            $table->string('assigned_to');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index('material_id');
            $table->index('batch_number');
            $table->index('customer');
            $table->index('status');
            $table->index('storage');
            $table->index('assigned_to');
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_tracking');
    }
};