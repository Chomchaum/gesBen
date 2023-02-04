<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenevole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benevoles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userid')->nullable();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('birthdate');
            $table->string('phone')->nullable();
            $table->enum('size',['XS','S','M','L','XL','XXL','XXXL']);

            $table->string('ancien_poste');
            $table->string('souhait_poste');

            $table->string('disponibilites');

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
        Schema::dropIfExists('benevoles');
    }
}
