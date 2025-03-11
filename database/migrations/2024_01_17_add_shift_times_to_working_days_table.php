<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('working_days', function (Blueprint $table) {
            $table->time('morning_start_time')->nullable()->after('start_time');
            $table->time('morning_end_time')->nullable()->after('morning_start_time');
            $table->time('afternoon_start_time')->nullable()->after('morning_end_time');
            $table->time('afternoon_end_time')->nullable()->after('afternoon_start_time');
            // Rename existing columns to avoid confusion
            $table->renameColumn('start_time', 'old_start_time');
            $table->renameColumn('end_time', 'old_end_time');
        });

        // Copy existing times to morning shift
        DB::statement('UPDATE working_days SET morning_start_time = old_start_time, morning_end_time = old_end_time');

        Schema::table('working_days', function (Blueprint $table) {
            $table->dropColumn(['old_start_time', 'old_end_time']);
        });
    }

    public function down()
    {
        Schema::table('working_days', function (Blueprint $table) {
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->dropColumn([
                'morning_start_time',
                'morning_end_time',
                'afternoon_start_time',
                'afternoon_end_time'
            ]);
        });
    }
};
