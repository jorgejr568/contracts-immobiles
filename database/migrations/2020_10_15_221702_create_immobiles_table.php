<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImmobilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immobiles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('email');
            $table->string('state');
            $table->string('city');
            $table->string('neighborhood');
            $table->string('street');
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
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
        Schema::dropIfExists('immobiles');
    }
}
