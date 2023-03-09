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
        Schema::table('resellers', function (Blueprint $table) {
            $table->string('bonus')->nullable();
            $table->string('reseller_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resellers', function (Blueprint $table) {
            $table->dropColumn('bonus');
            $table->dropColumn('reseller_id');
        });
    }
};
