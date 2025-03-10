<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_invites', function (Blueprint $table) {
            $table->foreign('invite_email')
                  ->references('email')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('user_invites', function (Blueprint $table) {
            $table->dropForeign(['invite_email']);
        });
    }
};
