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
        Schema::create('agen_reseller', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('user_reseller_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agen_reseller');
    }
};
