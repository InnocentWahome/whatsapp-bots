<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOshoProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osho_products', function (Blueprint $table) {
            $table->id();
            $table->string('etag')->nullable();
            $table->string('tcc_crop')->nullable();
            $table->string('tcc_product')->nullable();
            $table->string('tcc_targetpest')->nullable();
            $table->string('title')->nullable();
            $table->string('knowledgearticleid')->nullable();
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
        Schema::dropIfExists('osho_products');
    }
}
