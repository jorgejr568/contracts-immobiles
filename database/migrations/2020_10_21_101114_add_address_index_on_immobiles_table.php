<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressIndexOnImmobilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('immobiles', function (Blueprint $table) {
            foreach ([
                 'state',
                 'city',
                 'neighborhood',
                 'street',
                 'number',
             ] as $field){
                $table->index($field);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('immobiles', function (Blueprint $table) {
            $table->dropIndex([
                'state',
                'city',
                'neighborhood',
                'street',
                'number',
            ]);
        });
    }
}
