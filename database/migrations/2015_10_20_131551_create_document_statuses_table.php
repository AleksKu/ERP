<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('title');

            $table->string('desc')->nullable();


            $table->boolean('is_default');
            $table->boolean('is_completed');

            $table->boolean('is_system');

            $table->text('document_types');  //типы документов, в которых используется статус




            $table->timestamps();
            $table->softDeletes();

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('document_statuses');

    }
}
