<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_invites', function (Blueprint $table) {
            $table->id();
            $table->string('invite_email')->unique(); // Changed from 'email' to 'invite_email'
            $table->string('token');
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_invites');
    }
};
