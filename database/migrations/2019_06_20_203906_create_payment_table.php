<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_token')->nullable();
            $table->string('process_token')->nullable();
            $table->string('trans_id')->nullable();
            $table->string('method')->nullable();
            $table->integer('mode');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('USD');
            $table->integer('paid');
            $table->string('status', 50);
            $table->string('decline_reason')->nullable();
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
        Schema::dropIfExists('payment');
    }
}
