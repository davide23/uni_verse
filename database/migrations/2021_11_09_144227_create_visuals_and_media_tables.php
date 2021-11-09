<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisualsAndMediaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visuals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('width');

            $table->bigInteger('project_id')->nullable()->unsigned();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('path')->nullable(true);
            $table->integer('width')->nullable(true);
            $table->integer('height')->nullable(true);

            $table->string('video')->nullable(true);
            $table->integer('videowidth')->nullable(true);
            $table->integer('videoheight')->nullable(true);

            $table->boolean('enlargefirst')->nullable(true);
            $table->string('link')->nullable(true);

            $table->bigInteger('visual_id')->nullable()->unsigned();
            $table->foreign('visual_id')->references('id')->on('visuals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
        Schema::dropIfExists('visuals');
    }
}
