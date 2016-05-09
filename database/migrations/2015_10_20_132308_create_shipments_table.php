<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {

            $table->increments('id');

            $table->string('code');

            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('document_statuses');



            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('warehouses');

            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');


            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('users');
            $table->string('customer_name');
            $table->string('customer_email');


            $table->decimal('weight', 10, 2)->nullable()->unsigned();
            $table->decimal('volume', 10, 2)->nullable()->unsigned();

            $table->decimal('total_qty', 20, 2);  //общее кол-во товаров

            $table->decimal('total', 20, 2);  //общая стоимость отгрузки



            $table->timestamps();
            $table->softDeletes();

        });


        Schema::create('shipment_items', function (Blueprint $table) {

            $table->increments('id');


            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');

            $table->integer('shipment_id')->unsigned();
            $table->foreign('shipment_id')->references('id')->on('shipments');


            $table->integer('stock_id')->unsigned();
            $table->foreign('stock_id')->references('id')->on('stocks');




            $table->decimal('price', 20, 2);
            $table->decimal('qty', 20, 4);
            $table->decimal('total', 20, 2);  //общая стоимость строки


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
        Schema::drop('shipment_items');
        Schema::drop('shipments');
    }
}
