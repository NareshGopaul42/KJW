<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_usage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('employee_id');
            $table->decimal('initial_weight', 10, 2);
            $table->decimal('final_weight', 10, 2)->nullable();
            $table->decimal('loss', 10, 2)->nullable();
            $table->string('unit_of_measure', 10)->default('dwt');
            $table->string('batch_number');
            $table->text('notes')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('material_id')->references('material_id')->on('materials');
            $table->foreign('employee_id')->references('employee_id')->on('employees');
            $table->foreign('batch_number')->references('batch_number')->on('job_batches');

            // Indexes
            $table->index('material_id');
            $table->index('employee_id');
            $table->index('batch_number');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_usage');
    }
};