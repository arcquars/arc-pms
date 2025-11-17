<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('code', 250);
            $table->string('name', 250);
            $table->decimal('price_reference', 10, 2);
            $table->decimal('price_minimum', 10, 2);
            $table->decimal('coste', 10, 2)->default(0);

            $table->integer('measure')->nullable();

            $table->text('description');
            $table->boolean('active')->default(true);
            $table->boolean('delete');
            $table->bigInteger('sorted')->default(0);

            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('filename')->nullable();
            $table->string('filename500')->nullable();

            $table->bigInteger('category')->unsigned();
            $table->bigInteger('factory')->unsigned();

            $table->foreign('category')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('factory')->references('id')->on('factories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
