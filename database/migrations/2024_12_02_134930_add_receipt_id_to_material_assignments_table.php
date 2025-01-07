<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('material_assignments', function (Blueprint $table) {
            $table->foreignId('receipt_id')
                  ->nullable()
                  ->constrained('material_receipts', 'id')
                  ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::table('material_assignments', function (Blueprint $table) {
            $table->dropForeign(['receipt_id']);
            $table->dropColumn('receipt_id');
        });
    }
};