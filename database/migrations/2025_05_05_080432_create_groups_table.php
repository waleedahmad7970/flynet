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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('comment')->nullable();
            $table->boolean('default')->default(0);
            $table->boolean('external_default')->default(0);
            $table->boolean('is_active')->default(0);
            $table->boolean('panic_alert')->default(0);
            $table->boolean('view_recording')->default(0);
            $table->boolean('enable_chat')->default(0);
            $table->boolean('panic_notification')->default(0);
            $table->boolean('analytical_notification')->default(0);
            $table->boolean('offline_notification')->default(0);

            $table->integer('createdby_id')->nullable();
            $table->integer('updatedby_id')->nullable();
            $table->integer('deletedby_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
};
