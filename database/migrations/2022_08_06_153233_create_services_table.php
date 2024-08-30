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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('api_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('api_service');
            $table->boolean('status')->default(1);
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('quantity_min');
            $table->integer('quantity_max');
            $table->decimal('price', 10, 3);
            $table->boolean('refill')->default(0);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('api_id')->references('id')->on('apis')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
