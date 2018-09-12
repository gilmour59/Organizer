<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOgmInOutFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ogm_in_out_files', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('to');
            $table->string('from');
            $table->string('name');
            $table->text('subject');
            $table->boolean('letter');
            $table->string('file')->nullable();
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
        Schema::dropIfExists('ogm_in_out_files');
    }
}
