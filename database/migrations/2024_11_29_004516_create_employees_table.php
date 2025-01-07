<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_id');
            $table->string('username')->unique();
            $table->string('proper_name');  // Full name of employee
            
            // Contact Information
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            
            // Work Information
            $table->string('workshop')->nullable();  // Changed from warehouse
            $table->string('language')->default('en');
            $table->string('role')->nullable();      // Employee role/position
            $table->string('access_level')->notNull();  // Added access level field
            
            // Employee status and settings
            $table->string('status')->default('active');
            $table->boolean('is_locked')->default(false);
            $table->timestamp('last_activity')->nullable();
            $table->timestamp('password_expiry_date')->nullable();
            $table->boolean('password_never_expires')->default(false);
            $table->timestamp('password_change_date')->nullable();
            
            // Branch and department info
            $table->string('default_branch')->nullable();
            $table->string('department')->nullable();
            
            // Additional settings
            $table->json('valid_workshops')->nullable();   // Changed from warehouses
            $table->json('valid_branches')->nullable();    
            
            // Standard timestamps
            $table->timestamps();
            
            // Foreign key to users table for authentication
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};