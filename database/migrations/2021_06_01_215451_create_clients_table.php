<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table){
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone')->unique();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('coordinates')->nullable();
            $table->string('bincode');
            $table->unsignedBigInteger('type_client_id')->nullable();
            $table->foreign('type_client_id')
            ->references('id')
            ->on('type_clients')
            ->onUpdate('cascade')
            ->onDelete('cascade');
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
        Schema::dropIfExists('clients');
    }
}