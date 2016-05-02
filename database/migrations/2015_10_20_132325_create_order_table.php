<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->increments('id');

            $table->string('code');

            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('document_statuses');



            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('warehouses');

            $table->integer('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations');


            $table->integer('customer_id')->nullable()->unsigned();
            $table->foreign('customer_id')->references('id')->on('users');
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();


            $table->decimal('weight', 10, 2)->nullable()->unsigned();
            $table->decimal('volume', 10, 2)->nullable()->unsigned();

            $table->decimal('total_qty', 20, 2)->default(0);  //общее кол-во товаров

            $table->decimal('total', 20, 2)->default(0);  //общая стоимость отгрузки



            $table->timestamps();
            $table->softDeletes();

        });


        Schema::create('order_items', function (Blueprint $table) {

            $table->increments('id');


            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');

            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');


            $table->integer('stock_id')->unsigned();
            $table->foreign('stock_id')->references('id')->on('stocks');




            $table->decimal('price', 20, 2);
            $table->decimal('qty', 20, 4);
            $table->decimal('total', 20, 2)->nullable();  //общая стоимость строки


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
        Schema::drop('order_items');
        Schema::drop('orders');
    }
}
