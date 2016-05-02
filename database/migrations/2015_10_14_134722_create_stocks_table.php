<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {

            $table->increments('id');




            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');

            $table->string('stock_code')->nullable(); //код на складе
            $table->string('stock_box')->nullable(); //ячейка на складе



            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('warehouses');


            $table->decimal('qty', 20, 4)->default(0);
            $table->decimal('reserved', 20, 4)->default(0);
            $table->decimal('available', 20, 4)->default(0);
            $table->decimal('min_qty', 20, 4)->default(0);
            $table->decimal('ideal_qty', 20, 4)->default(0);
          //  $table->decimal('backordered', 20, 4)->default(0);

            $table->decimal('total', 20, 2)->default(0);

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
        Schema::drop('stocks');
    }
}
