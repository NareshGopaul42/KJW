<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('material_receipts', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->constrained('customers', 'customer_id');
        });
    }

    public function down()
    {
        Schema::table('material_receipts', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });
    }
};