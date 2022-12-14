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
        Schema::create('loisirs', function (Blueprint $table) {
            $table->id();
            $table->string('nom_loisir');
            $table->string('description_loisir');
            $table->bigInteger('lieu_id')->unsigned();
            $table->foreign('lieu_id')
            ->references('id')
            ->on('lieux');
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
        Schema::dropIfExists('loisirs');
    }
};
