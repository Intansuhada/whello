<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inactivated_user_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('token')->unique();
            $table->string('role')->default('member');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('expires_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inactivated_user_accounts');
    }
};
