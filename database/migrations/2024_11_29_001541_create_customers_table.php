<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('phone', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
            
            $table->unique(['first_name', 'last_name', 'phone'], 'unique_customer');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};