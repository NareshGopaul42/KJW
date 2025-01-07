<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id('seller_id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('phone', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('id_number', 50)->nullable();
            
            // Company information
            $table->string('company_name', 100)->nullable();
            $table->string('company_reg_number', 50)->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_phone', 15)->nullable();
            $table->string('company_email', 100)->nullable();
            $table->string('position_in_company', 50)->nullable();
            
            $table->timestamps();
            
            $table->unique(['first_name', 'last_name', 'phone'], 'unique_seller');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sellers');
    }
};