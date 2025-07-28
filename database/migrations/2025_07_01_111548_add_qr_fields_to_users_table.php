<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('google2fa_secret')->nullable()->after('address');
            $table->boolean('google2fa_enabled')->default(false)->after('google2fa_secret');
            $table->string('qr_login_token')->nullable()->after('google2fa_enabled');
            $table->timestamp('qr_login_token_expires_at')->nullable()->after('qr_login_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google2fa_secret', 'google2fa_enabled', 'qr_login_token', 'qr_login_token_expires_at']);
        });
    }
};
