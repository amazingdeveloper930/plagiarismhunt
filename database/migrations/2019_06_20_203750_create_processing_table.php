<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processing', function (Blueprint $table) {
            $table->bigIncrements('processing_id');
            $table->string('processing_token', 30)->nullable();
            $table->integer('project_id');
            $table->integer('method_id');
            $table->integer('status'); // 0:uploaded  1: processing 2:ready
            $table->float('mark')->default(0);
            $table->text('result_data')->nullable();
            $table->boolean('markable')->default(false);
            $table->boolean('detailshowable')->default(false);
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
        Schema::dropIfExists('processing');
    }
}
