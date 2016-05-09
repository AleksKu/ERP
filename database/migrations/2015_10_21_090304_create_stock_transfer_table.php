<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transfers', function (Blueprint $table) {

            $table->increments('id');
            $table->string('code');

            $table->string('status');
            $table->boolean('is_reserved');

            $table->string('desc');



            $table->integer('source_warehouse_id')->unsigned();
            $table->foreign('source_warehouse_id')->references('id')->on('warehouses');


            $table->integer('target_warehouse_id')->unsigned();
            $table->foreign('target_warehouse_id')->references('id')->on('warehouses');



            $table->integer('source_company_id')->unsigned();
            $table->foreign('source_company_id')->references('id')->on('companies');

            $table->integer('target_company_id')->unsigned();
            $table->foreign('target_company_id')->references('id')->on('companies');





            $table->decimal('weight', 10, 2)->nullable()->unsigned();
            $table->decimal('volume', 10, 2)->nullable()->unsigned();

            $table->decimal('total', 20, 2);  //общая стоимость прихода
        });



        Schema::create('stock_transfer_items', function (Blueprint $table) {


            $table->increments('id');


            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');

            $table->integer('stock_id')->unsigned();
            $table->foreign('stock_id')->references('id')->on('stocks');

            $table->integer('transfer_id')->unsigned();
            $table->foreign('transfer_id')->references('id')->on('stock_transfers');





            $table->decimal('price', 20, 2);
            $table->decimal('qty', 20, 4);


            $table->decimal('weight', 10, 2)->nullable()->unsigned();
            $table->decimal('volume', 10, 2)->nullable()->unsigned();



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
        Schema::drop('stock_transfer_items');
        Schema::drop('stock_transfers');
    }
}
