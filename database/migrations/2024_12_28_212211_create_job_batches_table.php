<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number')->unique();
            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('status', 20)->default('pending');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('material_id')->references('material_id')->on('materials');
            $table->foreign('employee_id')->references('employee_id')->on('employees');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_batches');
    }
};