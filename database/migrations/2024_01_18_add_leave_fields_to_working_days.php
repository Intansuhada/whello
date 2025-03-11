<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('working_days', function (Blueprint $table) {
            $table->string('leave_type')->nullable();
            $table->string('leave_description')->nullable();
        });
    }

    public function down()
    {
        Schema::table('working_days', function (Blueprint $table) {
            $table->dropColumn(['leave_type', 'leave_description']);
        });
    }
};
