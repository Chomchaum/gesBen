<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvenementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->foreignId('user_id')->constrained();
            $table->string('organisation')->nullable();
            $table->longText('description')->nullable();
            $table->string('site_web')->nullable();
            $table->json('reseaux_sociaux')->nullable();
            $table->boolean('private')->default(true);
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
        Schema::dropIfExists('evenements');
    }
}
