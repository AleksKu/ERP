<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockReservesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_reserves', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');


            $table->string('status');

            $table->morphs('documentable');

            $table->string('desc');


            $table->integer('warehouse_id')->nullable()->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('warehouses');

            $table->decimal('weight', 10, 2)->nullable()->unsigned();
            $table->decimal('volume', 10, 2)->nullable()->unsigned();

            $table->decimal('total', 20, 2)->nullable();  //общая стоимость прихода

            $table->timestamps();
            $table->softDeletes();

        });


        Schema::create('stock_reserve_items', function (Blueprint $table) {

            $table->increments('id');


            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');

            $table->integer('stock_id')->unsigned();
            $table->foreign('stock_id')->references('id')->on('stocks');

            $table->integer('stock_reserve_id')->unsigned();
            $table->foreign('stock_reserve_id')->references('id')->on('stock_reserves');



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
        Schema::drop('stock_reserve_items');
        Schema::drop('stock_reserves');
    }
}
