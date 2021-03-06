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
            $table->integer('height_feet');
            $table->integer('height_inches');
            $table->integer('width_feet');
            $table->integer('width_inches');
            $table->integer('qty')->default(1);
            $table->enum('type', ['add', 'sub']);
            $table->unsignedBigInteger('total')->virtualAs('(((height_feet * width_feet) * 12) + (height_feet * width_inches) + (width_feet * height_inches))* qty');
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
