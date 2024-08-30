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
        Schema::table('refills', function (Blueprint $table) {
            $table->dateTime('completed_at')->nullable()->after('error');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('refills', function (Blueprint $table) {
            $table->dropColumn(['completed_at']);
        });
    }
};
