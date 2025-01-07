<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('material_assignments', function (Blueprint $table) {
            $table->id('assignment_id');
            $table->foreignId('material_id')->constrained('materials', 'material_id');
            $table->foreignId('employee_id')->constrained('employees', 'employee_id');
            $table->foreignId('customer_id')->nullable()->constrained('customers', 'customer_id');
            $table->decimal('weight_assigned', 10, 3);
            $table->decimal('weight_returned', 10, 3)->nullable();
            $table->decimal('loss', 10, 3)->nullable();
            $table->text('task_description');
            $table->string('workshop')->nullable();  // Changed from warehouse
            $table->date('date_assigned');
            $table->date('date_due')->nullable();
            $table->date('date_returned')->nullable();
            $table->string('status', 50)->default('Assigned');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_assignments');
    }
};