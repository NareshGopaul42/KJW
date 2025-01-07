<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('status')->default('Active')->after('address');
            $table->text('notes')->nullable()->after('status');
            $table->string('preferred_contact_method')->nullable()->after('notes');
            $table->timestamp('last_visit')->nullable()->after('preferred_contact_method');
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'notes',
                'preferred_contact_method',
                'last_visit'
            ]);
        });
    }
};