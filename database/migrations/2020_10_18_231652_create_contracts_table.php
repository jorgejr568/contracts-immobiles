<?php

use App\Models\Contract;
use App\Models\Immobile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->foreignIdFor(Immobile::class, 'immobile_id')->primary();
            $table->string('document_type', 10)->index();
            $table->string(
                'document_number',
                Contract::DOCUMENT_TYPE_ENTITY_LENGTH,
            );
            $table->string('receiver_email');
            $table->string('receiver_name');
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
        Schema::dropIfExists('contracts');
    }
}
