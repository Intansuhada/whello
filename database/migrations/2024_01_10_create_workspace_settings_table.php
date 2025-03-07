<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('workspace_settings', function (Blueprint $table) {
            $table->id();
            
            // Workspace Configuration
            $table->string('workspace_name')->nullable();
            $table->string('photo_profile')->nullable();
            $table->text('description')->nullable();
            $table->string('url_slug')->nullable();
            $table->string('owner_email')->nullable();
            $table->integer('team_members')->default(0);
            
            // Regional Settings
            $table->string('timezone')->default('UTC+07:00');
            $table->enum('time_format', ['12', '24'])->default('24');
            $table->string('date_format')->nullable();
            $table->string('default_language')->default('en');
            $table->string('default_currency')->default('IDR');
            $table->decimal('default_hourly_rate', 10, 2)->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workspace_settings');
    }
};
