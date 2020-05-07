<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('project_id');
            $table->string('project_token', 30);
            $table->string('email')->nullable();
            $table->text('uploaded_data'); // file name / google doc url / text
            $table->text('data')->nullable();
            $table->string('type'); //  "file" / "google_doc" / "text"
            $table->boolean('verified')->default(false);
            $table->boolean('is_paid_openreport')->default(false);
            $table->boolean('is_paid_checkothers')->default(false);
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
        Schema::dropIfExists('projects');
    }
}
