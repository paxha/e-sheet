<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sheet_id');
            $table->string('description')->nullable();
            $table->integer('height');
            $table->integer('width');
            $table->enum('type', ['add', 'sub']);
            $table->integer('total')->virtualAs('height * width');
            $table->timestamps();

            $table->foreign('sheet_id')->references('id')->on('sheets')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calculations');
    }
}
