<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOshoContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osho_contacts', function (Blueprint $table) {
            $table->id();

            $table->string('etag')->nullable();
            $table->string('address1_county')->nullable();
            $table->string('firstname')->nullable();
            $table->string('fullname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('mobilephone')->nullable();
            $table->string('contactid')->nullable();

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
        Schema::dropIfExists('osho_contacts');
    }
}
